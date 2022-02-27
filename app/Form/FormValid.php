<?php

namespace App\Form;

use Yaml;

class FormValid
{

    private $validRule;

    public function __construct(string $filePath) 
    {
        $filePath = app_path('Form/validfile/' . $filePath);
        if (file_exists($filePath)) {
            $this->validRule =  Yaml::parse(file_get_contents($filePath));
        }
    }

    public function getValidRule(): array
    {
        $validArray = [];
        $validHash = Collect($this->validRule)
            ->map(function ($v) {
                $v['valid_rule'] = implode("|", $v['valid_rule']);
                return $v;
            })
            ->each(function ($v) use (&$validArray) {
                $validArray[$v['name']] = $v['valid_rule'];
            });

        return $validArray;
    }
}