<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use phpDocumentor\Reflection\DocBlock\Tags\Author;

class Parser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse authors';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        for ($i=1; $i <= 101; $i++){

        $page = file_get_contents('https://book24.ua/authors/?PAGEN_1='.$i);
        $author_element = explode( '<div class="vendors-section-item">', $page);
        unset($author_element[0]);

        foreach ($author_element as $value){
            $imgStart = explode('<img src="', $value)[1];
            $imgUrl = explode ('" width', $imgStart)[0];

            $nameStart = explode( '<span class="item-title">', $value)[1];
            $fullName = explode ('</span>', $nameStart)[0];

            $fullName = preg_replace('/ {2,}/', ' ', $fullName);

            $fullName = explode (' ', $fullName);

            $firstName = $fullName[0];

            $author = new \App\Author();

            $firstName = trim($firstName, $character_mask = " \t\n\r\0\x0B");

            echo $firstName;
            $author->first_name = $firstName;


        if (isset($fullName[1])){
            $middleName = $fullName[1];
            echo $middleName;
            $author->middle_name = $middleName;
        }

        if (isset($fullName[2])){
            $lastName = $fullName[2];
            echo $lastName;
            $author->last_name = $lastName;
        }
            $tmpImgName = explode('/', $imgUrl);
            $imgName = end($tmpImgName);
            $pathToImg = 'resources/files/'.$imgName;
            file_put_contents($pathToImg, file_get_contents('https://book24.ua/'.$imgUrl));
            $author->path_to_img = $pathToImg;
            $author->save();


        }

}
    }
}
