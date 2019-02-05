    <?php
     
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
     
    $this->title = 'Регистрация';
    $this->params['breadcrumbs'][] = $this->title;
    ?>
    <div class="site-signup">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Пожалуйста заполните следующие поля для регистрации:</p>
        <div class="row">
            <div class="col-lg-5">
     
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Введите ваше имя') ?>
                    <?= $form->field($model, 'email')->label('Введите ваш email') ?>
                    <?= $form->field($model, 'password')->passwordInput()->label('Введите пароль') ?>
                    <div class="form-group">
                        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
     
            </div>
        </div>
    </div>