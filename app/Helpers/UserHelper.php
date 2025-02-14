<?php
if (!function_exists('getCountUserProfileFollowing')) {
    function getCountUserProfileFollowing( $profileUserId,$sessionUserId)
    { 
        // Build the query
        $query = \DB::table('users')
            ->whereRaw("FIND_IN_SET(?, user_followers)", [$profileUserId])
            ->where('id', $sessionUserId)
            ->where('user_status', 1);
        
        // Get the raw SQL query
        
        
        // Return the count
        return $query->count();
    }
}



/*
if (!function_exists('helper_update_follower_wish')) {   

    function helper_update_follower_wish($profileUserId, $sessionUserId)
    {   
        // Check if the sender is already in the user's followers list
        $checkUserFollowers = DB::table('users')
            ->whereRaw("FIND_IN_SET(?, user_followers)", [$sessionUserId])
            ->where('id', $profileUserId)
            ->exists();

        if (!$checkUserFollowers) {
            // Add as Follower
            DB::table('users')
                ->where('id', $profileUserId)
                ->whereRaw("FIND_IN_SET(?, user_followers) = 0", [$sessionUserId])
                ->update([
                    'user_followers' => DB::raw("IF(user_followers = '', '$sessionUserId', CONCAT(user_followers, ',$sessionUserId'))")
                ]);

            echo 0; // Added as follower
        } else {
            // Remove as Follower
            DB::table('users')
                ->where('id', $profileUserId)
                ->update([
                    'user_followers' => DB::raw("TRIM(BOTH ',' FROM REPLACE(REPLACE(user_followers, '$sessionUserId', ''), ',,', ','))")
                ]);

            echo 1; // Removed as follower
        }
    }
}
*/


if (!function_exists('helper_update_follower_wish')) {   

    function helper_update_follower_wish($profileUserId, $sessionUserId)
    {   
        // Check if the sender is already in the user's followers list
        $checkUserFollowers = DB::table('users')
            ->whereRaw("FIND_IN_SET(?, user_followers)", [$sessionUserId])
            ->where('id', $profileUserId)
            ->exists();

        if (!$checkUserFollowers) {
            // Add as Follower
            DB::table('users')
                ->where('id', $profileUserId)
                ->whereRaw("FIND_IN_SET(?, user_followers) = 0", [$sessionUserId])
                ->update([
                    'user_followers' => DB::raw("IF(user_followers = '', '$sessionUserId', CONCAT(user_followers, ',$sessionUserId'))")
                ]);

            echo 0; // Added as follower
        } else {
            // Remove as Follower (ensure exact match)
            DB::table('users')
                ->where('id', $profileUserId)
                ->update([
                    'user_followers' => DB::raw("
                        TRIM(BOTH ',' FROM 
                            REPLACE(
                                CONCAT(',', user_followers, ','), 
                                CONCAT(',$sessionUserId,'), 
                                ','
                            )
                        )
                    ")
                ]);

            echo 1; // Removed as follower
        }
    }
}

?>