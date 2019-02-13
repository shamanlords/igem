<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
//require 'vendor/autoload.php'
// подключение библиотеки PhpWord
//use PhpOffice\PhpWord\PhpWord;
//use PhpOffice\PhpWord\Autoloader;
/*
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$phpWord->setDefaultFontName('Times New Roman');
$phpWord->setDefaultFontSize(14);

//параметры всего документа в целом
$properties = $phpWord->getDocInfo();

//основные параметры документа
$properties->setCreator('Igor');
$properties->setCompany('Igem Ras');
$properties->setTitle('Title');
$properties->setDescription('Description');
$properties->setCategory('My category');
$properties->setLastModifiedBy('My name');
$properties->setCreated(mktime(0, 0, 0, 3, 12, 2015));
$properties->setModified(mktime(0, 0, 0, 3, 14, 2015));
$properties->setSubject('My subject');
$properties->setKeywords('my, key, word');

//создание прямоугольного раздела
$sectionStyle = array( 
 'orientation' => 'landscape',
 'marginTop' => \PhpOffice\PhpWord\Shared\Converter::pixelToTwip(10),
 'marginLeft' => 600,
 'marginRight' => 600,
 'colsNum' => 1,
 'pageNumberingStart' => 1,
 'borderBottomSize'=>100,
 'borderBottomColor'=>'C0C0C0' 
 );
$section = $phpWord->addSection($sectionStyle); 

//добавление текста в документ
$text = "PHPWord is a library written in pure PHP that provides a set of classes to write to and read from different document file formats.";
$fontStyle = array('name'=>'Arial', 'size'=>36, 'color'=>'075776', 'bold'=>TRUE, 'italic'=>TRUE);
$parStyle = array('align'=>'right','spaceBefore'=>10);
$section->addText($text, $fontStyle,$parStyle);

//$file = 'HelloWorld.html';
header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="word.html"');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');
$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
$xmlWriter->save("php://output");
*/
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>

    <code><?= __FILE__ ?></code>
</div>




