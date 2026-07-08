<?php

namespace App\Lib\Rewards;

use Exception;

/** Thrown when a reward action is not currently allowed (e.g. already claimed). */
class RewardException extends Exception
{
}
