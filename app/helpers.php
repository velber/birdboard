<?php

function gravatar_url(string $email): string
{
    return sprintf("https://gravatar.com/avatar/%s", md5($email)) . http_build_query([
            's' => 60,
        ]);
}