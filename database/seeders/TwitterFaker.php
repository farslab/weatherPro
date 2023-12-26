<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;


class TwitterFaker extends Seeder
{
    protected $usernames = [];

    public function run()
    {
        $this->loadUsernames();

        $faker = Faker::create();

        $users = [];
        $tweetData = $this->loadTweetData();

        foreach ($this->usernames as $username) {
            $user = [
                'username' => $username,
                'name' => $faker->name,
                'followers_count' => $faker->numberBetween(20, 200),
                'following_count' => $faker->numberBetween(20, 200),
                'language' => $faker->languageCode,
                'region' => $faker->countryCode,
                'tweets' => [],
                'following' => [],
                'followers' => [],
            ];

            for ($j = 0; $j < $faker->numberBetween(50, 75); $j++) {
                $user['tweets'][] = $faker->realText(75,100);
            }

            $user['following'] = $this->getRandomUsernamesExcept($username, $user['following_count']);
            $user['followers'] = $this->getRandomUsernamesExcept($username, $user['followers_count']);

            $users[] = $user;
        }

        $jsonContent = json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $filePath = base_path('twitter_data_en_30K.json');
        File::put($filePath, $jsonContent);

        $this->command->info('Sahte Twitter verileri oluşturuldu ve dosyasına kaydedildi.');
    }

    protected function loadUsernames()
    {
        $filePath = base_path('new_usernames.json');
        $this->usernames = json_decode(File::get($filePath), true);
    }

    protected function loadTweetData()
    {
        $filePath = base_path('wiki.tr.txt');
        $tweetData = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        return $tweetData;
    }

    protected function getRandomUsernamesExcept($excludeUsername, $count)
    {
        $availableUsernames = array_diff($this->usernames, [$excludeUsername]);
        $randomUsernames = array_rand($availableUsernames, $count);

        return is_array($randomUsernames) ? array_map(fn ($index) => $availableUsernames[$index], $randomUsernames) : [$availableUsernames[$randomUsernames]];
    }

    protected function getRandomTweet($tweetData)
    {
        return $tweetData[array_rand($tweetData)];
    }
}
