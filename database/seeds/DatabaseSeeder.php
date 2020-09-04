<?php

use App\Channel;
use App\Comment;
use App\Subscription;
use App\User;
use App\Video;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class, 20)->create();

        $users->each(function (User $user) {
            
            factory(Channel::class)->create([

                'name' => $user->name,
                'user_id' => $user->id,
            ]);

        });


        $u_ids = User::all()->pluck('id')->all();
        $c_ids = Channel::all()->pluck('id')->all();

        for ($i=1;$i<200;$i++) {

            $u_id = $u_ids[array_rand($u_ids)];
            $user = User::find($u_id);

            $c_id = $c_ids[array_rand($c_ids)];
            $channel = Channel::find($c_id);

            if ( $channel->user_id != $user->id && !$channel->subscriptions->contains($user->id)) {

                factory(Subscription::class)->create([
                    'user_id' => $user->id,
                    'channel_id' => $channel->id
                ]);
            }
        }

        $video = factory(Video::class)->create(['channel_id' => User::first()->channel->id]);
        for ($i=1;$i<50;$i++) {

            $u_id = $u_ids[array_rand($u_ids)];
            $user = User::find($u_id);

            factory(Comment::class)->create([
                'video_id' =>  $video->id,
                'user_id' => $user->id,
            ]);  
        }

        $co_ids = Comment::all()->pluck('id')->all();
        for ($i=1;$i<50;$i++) {

            $u_id = $u_ids[array_rand($u_ids)];
            $user = User::find($u_id);

            $c_id = $co_ids[array_rand($co_ids)];
            $comment = Comment::find($c_id);

            factory(Comment::class)->create([
                'video_id' =>  $video->id,
                'user_id' => $user->id,
                'comment_id' => $comment->id,
            ]);    
        }

    }
}
