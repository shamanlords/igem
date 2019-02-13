<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\SignupForm;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Autoloader;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
		/*
		if (!\Yii::$app->user->can('updateNews')) {
		throw new ForbiddenHttpException('Access denied');
	}*/
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
					[
						'allow' => true,
						'roles' => ['contact'],
					],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
	{		
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
	 
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
	
	
    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
		if (Yii::$app->user->can('contact')) {
		
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
		}
		else {
			exit ('Ты - не админ!');
			}
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
			if(Yii::$app->user->isGuest){
			return $this->goHome();
		}
		else{
		$userModel = Yii::$app->user->identity; //получение модели активного пользователя
		//$l=$userModel->username;
		//echo '<pre>'; print_r($userModel); die; //вывод данных модели
		
		$phpWord = new \PhpOffice\PhpWord\PhpWord();		
		//$document = \PhpOffice\PhpWord\IOFactory::load('template.docx');	// чтание шаблона как исходного файла
		
		// чтение и запись переменных в шаблон		
		$tpl = $phpWord->loadTemplate('template.docx'); //шаблон	
		$tpl->setValue('d_num', $userModel->id); 
		$tpl->setValue('d_hash', $userModel->password_hash); 
		$tpl->setValue('d_mail', $userModel->email); 
		$tpl->setValue('d_user', $userModel->username); 
		header("Content-Type:application/vnd.ms-office"); 
		header('Content-Disposition: attachment; filename="test.docx"'); 
		$tpl->saveas("php://output"); // запись файла через браузера
		exit;
		//$tpl->saveas('templat.docx'); //запись на локальный сервер
		
		// создание и запись нового файла
		/*
		$phpWord->setDefaultFontName('Times New Roman');
		$phpWord->setDefaultFontSize(14);
		$properties = $phpWord->getDocInfo();
		$properties->setCreator('Name');
		$properties->setCompany('Company');
		$properties->setTitle('Title');
		$properties->setDescription('Description');
		$properties->setCategory('My category');
		$properties->setLastModifiedBy('My name');
		$properties->setCreated(mktime(0, 0, 0, 3, 12, 2015));
		$properties->setModified(mktime(0, 0, 0, 3, 14, 2015));
		$properties->setSubject('My subject');
		$properties->setKeywords('my, key, word'); 
		$sectionStyle = array(
 
		 'orientation' => 'portrait',
		 'marginTop' => \PhpOffice\PhpWord\Shared\Converter::pixelToTwip(50),
		 'marginLeft' => 600,
		 'marginRight' => 600,
		 'colsNum' => 1,
		 'pageNumberingStart' => 1,
		 'borderBottomSize'=>100,
		 'borderBottomColor'=>'C0C0C0'
		 
		 );
		$section = $phpWord->addSection($sectionStyle); 
		$text = "Привет Мир!!!";
		$fontStyle = array('name'=>'Arial', 'size'=>36, 'color'=>'075776', 'bold'=>TRUE, 'italic'=>TRUE);
		$parStyle = array('align'=>'right','spaceBefore'=>10);
		$section->addText(htmlspecialchars($text), $fontStyle,$parStyle);
		
		header("Content-Description: File Transfer");
		header('Content-Disposition: attachment; filename="first.docx"');
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');		
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');		
		header('Expires: 0');

		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$objWriter->save("php://output");
		*/
		}
		
        return $this->render('about');
    }
	
	public function actionSignup()
    {
        $model = new SignupForm();
 
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
 
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
	
	/*
	    public function actionAddAdmin() {
        $model = User::find()->where(['username' => 'admin'])->one();
        if (empty($model)) {
            $user = new User();
            $user->username = 'admin';
            $user->email = 'estera-st@mail.ru';
            $user->setPassword('admin');
            $user->generateAuthKey();
            if ($user->save()) {
                echo 'good';
            }
        }
    }
	*/
}
