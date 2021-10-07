<?php

class EchoRetroEngineering
{
    /**
     * @throws Exception
     *
     *  Return multi-dimensional array of ranges based on overlaping ranges (format -> $array[min, max])
     */
    public function fooGuess(array $intsArray): array
    {
        $this->validateArray($intsArray);

        $intsArraySorted = [];

        foreach ($intsArray as $key => $array) {
            if ($key === 0) {
                $intsArraySorted = $array;
            }

            foreach ($intsArraySorted as $tmpKey => $tmp) {
                if ($this->overlap($tmp, $array)) {
                    $intsArraySorted[$tmpKey][0] = min(array_merge($tmp, $array));
                    $intsArraySorted[$tmpKey][1] = max(array_merge($tmp, $array));
                } else {
                    $intsArraySorted[count($intsArraySorted) + 1] = $array;
                }
            }
        }

        return $intsArraySorted;
    }

    /**
     * Test if ranges are overlapping each other
     */
    public function overlap(array $base, array $toCompare): bool
    {
        if (
            $toCompare[0] === $base[1] ||
            $toCompare[1] === $base[0] ||
            $toCompare[0] >= $base[0] && $toCompare[1] <= $base[1] ||
            $toCompare[0] <= $base[0] && $toCompare[1] >= $base[1]
        ) {
            return true;
        }

        return false;
    }

    /**
     * @throws Exception
     *
     * Test if the array is well formatted
     */
    public function validateArray(array $toValidate): void
    {
        if (count($toValidate) !== 1) {
            throw new Exception("The array must contains only 2 ints arrays");
        }

        if ($toValidate[1] >= $toValidate[0]) {
            throw new Exception("The first argument must be an int smaller than the second argument");
        }
    }

    /**
     * @throws Exception
     *
     * Call the fooGuess method with set of test data
     */
    public function fooGuessTest(array $testArray = []): array
    {
        if (count($testArray) < 1) {
            $testArray = [
                [3, 6], [3, 4], [15, 20], [16, 17], [1, 4], [6, 10], [3, 6]
            ];
        }

        print $this->fooGuess($testArray);
    }
}
