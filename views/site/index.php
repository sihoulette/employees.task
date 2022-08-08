<?php

use yii\web\View;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\data\ActiveDataProvider;
use app\models\employee\Employee;
use yii\bootstrap4\ButtonGroup;
use yii\bootstrap4\Button;
use app\widgets\Alert;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/**
 * @var View               $this
 * @var Employee           $model
 * @var array              $ranks
 * @var ActiveDataProvider $dataProvider
 */

$this->title = Yii::$app->name; ?>

<?php Pjax::begin(['id' => 'form-pjax']) ?>
<div class="card">
    <div class="card-header">
        <?php if ($model->isNewRecord) : ?>
            Create employee
        <?php else : ?>
            Edit employee: <?= $model->getFullName() ?>
        <?php endif; ?>
    </div>
    <?= Alert::widget([]) ?>
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'id' => 'employee-form',
            'action' => $model->isNewRecord
                ? Url::to(['/employee/create'])
                : Url::to(['/employee/update', 'id' => $model->id]),
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
            ],
            'options' => [
                'data-refresh-action' => Url::to(['/'])
            ]
        ]) ?>
        <div class="row">
            <div class="col-lg-4">
                <?= $form->field($model, 'first_name') ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'last_name') ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'rank_id')->dropDownList($ranks, ['prompt' => 'Select rank']) ?>
            </div>
        </div>
        <div class="form-group d-flex justify-content-between">
            <?= Html::a('Reset', Url::to(['/']), [
                'class' => 'btn btn-primary',
            ]) ?>

            <?= Html::submitButton('Save', [
                'class' => 'btn btn-success', 'name' => 'save'
            ]) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
<?php Pjax::end() ?>

<?php Pjax::begin(['id' => 'grid-pjax']) ?>
<div class="card mt-3">
    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'first_name',
                    'value' => function ($model) {
                        return $model->first_name;
                    }
                ],
                [
                    'attribute' => 'last_name',
                    'value' => function ($model) {
                        return $model->last_name;
                    }
                ],
                [
                    'label' => 'Rank',
                    'attribute' => 'rank_id',
                    'value' => function ($model) {
                        return $model->rank->name;
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => null,
                    'label' => 'Actions',
                    'headerOptions' => ['style' => 'width: 2.5rem;'],
                    'value' => function ($model) {
                        return ButtonGroup::widget([
                            'buttons' => [
                                Button::widget([
                                    'tagName' => 'a',
                                    'label' => 'Edit',
                                    'options' => [
                                        'href' => '#',
                                        'class' => 'btn btn-primary',
                                        'data-handler' => 'update',
                                        'data-action' => Url::to(['/site/index', 'id' => $model->id]),
                                        'data-id' => $model->id,
                                        'data-pjax' => 0,
                                    ]
                                ]),
                                Button::widget([
                                    'tagName' => 'a',
                                    'label' => 'Delete',
                                    'options' => [
                                        'href' => '#',
                                        'class' => 'btn btn-danger',
                                        'data-handler' => 'delete',
                                        'data-action' => Url::to(['/employee/delete', 'id' => $model->id]),
                                        'data-pjax' => 0,
                                    ]
                                ]),
                            ]
                        ]);
                    }
                ],
            ]
        ]) ?>
    </div>
</div>
<?php Pjax::end() ?>