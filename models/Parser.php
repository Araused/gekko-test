<?php

namespace app\models;

use phpQuery;

class Parser
{
    /**
     * @param string $path
     * @return array
     */
    public static function parseFile(string $path)
    {
        $result = [];
        $balance = 0;
        phpQuery::newDocument(file_get_contents($path));

        foreach (pq('table:first tr') as $tr) {
            $date = pq('td.msdate:first', $tr);
            $pt = pq('td.mspt:last', $tr);

            if ($date->length && $pt->length) {
                $balance += (float) $pt->text();

                $result[] = [
                    'balance' => $balance,
                    'date' => $date->text(),
                    'pt' => $pt->text(),
                ];
            }
        }

        return $result;
    }
}