<?php /** @noinspection SpellCheckingInspection */

namespace Nemo9l\Uwuify;

class Uwuify
{
    protected static array $_faces = [
        '(・`ω´・)',
        ';;w;;',
        'OwO',
        'UwU',
        '>w<',
        '^w^',
        '\(^o\) (/o^)/',
        '( ^ _ ^)∠☆',
        '(U __ U)',
        '(*^*)',
        '(+_+)',
        '(/_;)',
        '(^.^)',
        '(♥_♥)',
        '*(^O^)*',
        '*(^o^)*',
        'ʕ•ᴥ•ʔ',
        '(*^.^*)',
        '(｡♥‿♥｡)'
    ];

    protected static array $_actions = [
        '*blushes*',
        '*nuzzles*',
        '*notices bulge*',
        '*whispers to self*',
        '*cries*',
        '*walks away*',
        '*sweats*',
        '*boops your nose*',
        '*sees bulge*'
    ];

    protected static array $_exclamations = [
        '!?',
        '?!!',
        '?!?1',
        '!!11',
        '?!1?'
    ];

    protected static array $_regexMaps = [
        '/(?:r|l)/' => 'w',
        '/(?:R|L)/' => 'W',
        '/n([aeiou])/' => 'ny$1',
        '/N([aeiou])/' => 'Ny$1',
        '/N([AEIOU])/' => 'Ny$1',
        '/ove/' => 'uv'
    ];

    public float $regexModifier = 1;
    public float $exclamationModifier = 1;
    public array $spaceModifier = [ 'faces' => 0.05, 'actions' => 0.075, 'stutters' => 0.1 ];

    /**
     * Constructor.
     *
     * @param float|null $regexModifier
     * @param float|null $exclamationModifier
     * @param array $spaceModifier
     */
    public function __construct(float $regexModifier = null, float $exclamationModifier = null, array $spaceModifier = [])
    {
        if($regexModifier !== null)
        {
            $this->regexModifier = $regexModifier;
        }

        if($exclamationModifier !== null)
        {
            $this->exclamationModifier = $exclamationModifier;
        }

        if($spaceModifier !== null)
        {
            if(isset($spaceModifier['faces']) && is_float($spaceModifier['faces']))
            {
                $this->spaceModifier['faces'] = $spaceModifier['faces'];
            }
            if(isset($spaceModifier['actions']) && is_float($spaceModifier['actions']))
            {
                $this->spaceModifier['actions'] = $spaceModifier['actions'];
            }
            if(isset($spaceModifier['stutters']) && is_float($spaceModifier['stutters']))
            {
                $this->spaceModifier['stutters'] = $spaceModifier['stutters'];
            }
        }
    }

    /**
     * Translate some words to uwu from a sentence.
     *
     * @param string $sentence
     * @return string
     */
    public function uwuifyWords(string $sentence): string
    {
        $words = explode(' ', $sentence);
        foreach($words as &$word)
        {
            if(filter_var($word, FILTER_VALIDATE_URL) !== false)
            {
                continue;
            }

            if(str_starts_with($word, '@'))
            {
                continue;
            }

            foreach(self::$_regexMaps as $regex => $replacement)
            {
                if($this->getRandomFloat() <= $this->regexModifier)
                {
                    $word = preg_replace($regex, $replacement, $word);
                }

                if($this->getUppercaseProportion($word) < 0.5)
                {
                    $word = lcfirst($word);
                }
            }
        }

        return implode(' ', $words);
    }

    /**
     * Translate some exclamations to uwu from a sentence.
     *
     * @param string $sentence
     * @return string
     */
    public function uwuifyExclamations(string $sentence): string
    {
        $words = explode(' ', $sentence);
        foreach($words as &$word)
        {
            if($this->getRandomFloat() > $this->exclamationModifier)
            {
                continue;
            }

            $replacedWord = preg_replace('/[?!]+$/', '', $word);
            if($word == $replacedWord)
            {
                continue;
            }

            $word = $replacedWord . self::$_exclamations[array_rand(self::$_exclamations)];
        }

        return implode(' ', $words);
    }

    /**
     * Translate some spaces to faces, action or stutters from a sentence.
     *
     * @param string $sentence
     * @return string
     */
    public function uwuifySpaces(string $sentence): string
    {
        $words = explode(' ', $sentence);

        $faceThreshold = $this->spaceModifier['faces'];
        $actionThreshold = $this->spaceModifier['actions'] + $faceThreshold;
        $stutterThreshold = $this->spaceModifier['stutters'] + $actionThreshold;

        foreach($words as &$word)
        {
            $firstCharacter = substr($word, 0, 1);

            if($this->getRandomFloat() <= $faceThreshold && self::$_faces)
            {
                $word .= ' ' . self::$_faces[array_rand(self::$_faces)];
            }
            elseif($this->getRandomFloat() <= $actionThreshold && self::$_actions)
            {
                $word .= ' ' . self::$_actions[array_rand(self::$_actions)];
            }
            elseif($this->getRandomFloat() <= $stutterThreshold)
            {
                $stutterCount = rand(1, 3);
                $word = str_repeat($firstCharacter . '-', $stutterCount) . $word;
            }
        }

        return implode(' ' , $words);
    }

    /**
     * Uwuify sentences.
     *
     * @param string $sentence
     * @return string
     */
    public function uwuify(string $sentence): string
    {
        $sentence = $this->uwuifyWords($sentence);
        $sentence = $this->uwuifyExclamations($sentence);
        return $this->uwuifySpaces($sentence);
    }

    /**
     * Get a random float between 0 and 1.
     *
     * @return float
     */
    private function getRandomFloat(): float
    {
        return mt_rand() / mt_getrandmax();
    }

    /**
     * Get a proportion of uppercase characters in a string.
     * @param string $word
     * @return float
     */
    private function getUppercaseProportion(string $word): float
    {
        $totalCharacters = strlen($word);
        $upperCharacters = 0;

        foreach(str_split($word) as $character)
        {
            if(strtoupper($character) == $character)
            {
                $upperCharacters++;
            }
        }

        return $upperCharacters / $totalCharacters;
    }
}