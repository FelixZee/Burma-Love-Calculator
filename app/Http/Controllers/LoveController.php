<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class LoveController extends Controller
{
    public function index()
    {
        return view('loves.index');
    }
    public function calculate(Request $request)
    {
        $data = $request->validate([
            'your' => 'required',
            'parter' => 'required',
        ]);

        $your = trim($data['your']);
        $parter = trim($data['parter']);

        // existing compatibility function (keep or replace)
        $score = $this->calculateCompatibility($your, $parter); // 0..100

        // generate exactly 5 steps (initial + 4 reductions) that end in the 2-digit score
        $steps = $this->generateFiveStepsFromScore($your, $parter, $score);

        $message = $this->messageForScore($score);


        return view('loves.result', compact('your', 'parter', 'score', 'message', 'steps'),[
            'loves' => $data
        ]);
    }
     protected function calculateCompatibility(string $lovemessage1, string $lovemessage2): int
    {
        // Simple stable calculation using crc32; result 0..100
        $hash = crc32(mb_strtolower($lovemessage1 . '|' . $lovemessage2));
        $score = $hash % 101; // 0..100
        return (int) $score;
    }

    protected function generateFiveStepsFromScore(string $male, string $female, int $score): array
{
    // Normalize score to 0..100
    $score = max(0, min(100, (int)$score));

    // prepare final digits
    if ($score === 100) {
        // rare: 3-digit case — handle if you care. Here we treat 100 as [1,0,0] and use 7 initial slots.
        $final = [1,0,0];
        $initialSlots = 7;
        $reductions = $initialSlots - count($final); // 4 reductions if initialSlots=7 and final len=3 -> 4 steps
    } else {
        $scoreStr = str_pad((string)$score, 2, '0', STR_PAD_LEFT); // e.g. 7 -> "07"
        $final = [ (int)$scoreStr[0], (int)$scoreStr[1] ];
        $initialSlots = 6;   // length 6 -> 4 reductions -> final length 2
        $reductions = 4;
    }

    // build an initial digits array that reduces to $final after $reductions
    // use the simple pattern [f0, 0, 0, ..., f1] of length $initialSlots
    $initialDigits = array_merge([ $final[0] ], array_fill(0, $initialSlots - 2, 0), [ $final[count($final)-1] ]);

    // split the 6 slots into two rows proportionally (based on character counts) so it looks natural
    $mChars = preg_split('//u', preg_replace('/\s+/u','', $male), -1, PREG_SPLIT_NO_EMPTY);
    $fChars = preg_split('//u', preg_replace('/\s+/u','', $female), -1, PREG_SPLIT_NO_EMPTY);
    $mCount = count($mChars);
    $fCount = count($fChars);
    $combined = max(1, $mCount + $fCount);

    // assign number of slots for male (at least 1, at most initialSlots-1)
    $maleSlots = (int) round($initialSlots * ($mCount / $combined));
    if ($maleSlots < 1) $maleSlots = 1;
    if ($maleSlots > $initialSlots - 1) $maleSlots = $initialSlots - 1;
    $femaleSlots = $initialSlots - $maleSlots;

    $maleRow = array_slice($initialDigits, 0, $maleSlots);
    $femaleRow = array_slice($initialDigits, $maleSlots);

    $steps = [];
    // Step 1 = initial two rows
    $steps[] = [
        'type' => 'initial',
        'rows' => [$maleRow, $femaleRow],
    ];

    // subsequent reductions
    $current = $initialDigits;
    for ($i = 0; $i < $reductions; $i++) {
        $next = [];
        for ($j = 0; $j < count($current) - 1; $j++) {
            $next[] = ($current[$j] + $current[$j+1]) % 10;
        }
        $steps[] = [
            'type' => 'reduced',
            'numbers' => $next,
        ];
        $current = $next;
    }

    return $steps;
}
    protected function messageForScore(int $score): string
{
    if ($score >= 90) {
        return 'Your love is destined to shine across the whole world 🎉';
    } elseif ($score >= 75) {
        return 'You both are deeply connected at heart ❤️';
    } elseif ($score >= 50) {
        return 'This could be a good beginning 🙂';
    } elseif ($score >= 30) {
        return 'There might be challenges, but with effort it can work .';
    } else {
        return 'With this low compatibility, love may be difficult to start — but trust and effort can make a difference.';
    }
}

}
