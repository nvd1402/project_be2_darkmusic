<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Category; // Import the Category model

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $songNames = [
            'Shape of You',
            'Blinding Lights',
            'Rolling in the Deep',
            'Bad Guy',
            'Someone Like You',
            'Perfect',
            'Uptown Funk',
            'Thinking Out Loud',
            'Love Yourself',
            'Despacito',
            'Senorita',
            'Let Her Go',
            'Believer',
            'Counting Stars',
            'See You Again',
            'Levitating',
            'Stay',
            'Happy',
            'Dance Monkey',
            'Can\'t Stop The Feeling!',
            'Cheap Thrills',
            'Roar',
            'Shallow',
            'Hello',
            'All of Me',
            'Memories',
            'Girls Like You',
            'Sugar',
            'Animals',
            'Radioactive',
            'Thunder',
            'Natural',
            'Demons',
            'The Scientist',
            'Yellow',
            'Viva La Vida',
            'Fix You',
            'Closer',
            'Something Just Like This',
            'Don\'t Let Me Down',
            'Stressed Out',
            'Heathens',
            'Ride',
            'Faded',
            'Alone',
            'Sing Me to Sleep',
            'Lily',
            'On My Way',
            'Darkside',
            'Legends Never Die',
            'Apologize',
            'Good Life',
            'Wherever You Will Go',
            'How You Remind Me',
            'Photograph',
            'Numb',
            'In The End',
            'Crawling',
            'Somewhere I Belong',
            'Bring Me To Life',
            'My Immortal',
            'Wake Me Up',
            'Hey Brother',
            'Waiting For Love',
            'The Nights',
            'Titanium',
            'Without You',
            'Burn',
            'Love Me Like You Do',
            'We Don\'t Talk Anymore',
            'Attention',
            'How Long',
            'Light Switch',
            'Treat You Better',
            'There\'s Nothing Holdin\' Me Back',
            'Mercy',
            'Lost in Japan',
            'Havana',
            'Never Be The Same',
            'Waka Waka',
            'Hips Don\'t Lie',
            'Whenever, Wherever',
            'La La La',
            'Bailando',
            'Hero',
            'Subeme La Radio',
            'A Thousand Years',
            'Jar of Hearts',
            'Just Give Me a Reason',
            'What About Us',
            'So What',
            'Try',
            'Because of You',
            'Stronger',
            'Since U Been Gone',
            'Firework',
            'Dark Horse',
            'E.T.',
            'Wide Awake'
        ];
        $sourceImagesSong = 'songs/images';
        $sourceAudioSongs = 'songs/audio';

        $imageSongs = Storage::disk('public')->files($sourceImagesSong);
        $AudioSongs = Storage::disk('public')->files($sourceAudioSongs);


        if (empty($imageSongs)) {
            $this->command->warn('Không tìm thấy ảnh trong thư mục');
            $imageSongs =  ['songs/images/default-song-image.jpg'];
        }
        if (empty($AudioSongs)) {
            $this->command->warn('Không tìm thấy file âm thanh trong thư mục');
            $AudioSongs =  ['songs/audio/default-song-image.jpg'];
        }

        // Fetch all category IDs.
        $categoryIds = Category::pluck('id')->toArray();

        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $randomName = $songNames[array_rand($songNames)];
            $randomImagePath = $imageSongs[array_rand($imageSongs)];
            $randomAudioSongs = $AudioSongs[array_rand($AudioSongs)];


            // Ensure a valid category ID is used.
            $randomCategoryId = $categoryIds[array_rand($categoryIds)] ?? null; // Use null if $categoryIds is empty

            $data[] = [
                'tenbaihat' => $randomName,
                'nghesi' => rand(1, 100),
                'theloai' => $randomCategoryId, // Use the ID here
                'anh_daidien' => $randomImagePath,
                'file_amthanh' => $randomAudioSongs,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('songs')->insert($data);
    }
}
