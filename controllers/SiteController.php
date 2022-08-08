<?php

namespace app\controllers;

use yii\web\Controller;
use yii\base\Module as BaseModule;
use app\services\rank\RankService;
use app\services\employee\EmployeeService;

/**
 * Class SiteController
 *
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @var EmployeeService $service
     */
    protected EmployeeService $service;

    /**
     * @param string          $id
     * @param BaseModule      $module
     * @param EmployeeService $service
     * @param array           $config
     */
    public function __construct(string $id, BaseModule $module, EmployeeService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $dataGet = $this->request->get();

        $data['ranks'] = RankService::getListOptions();
        $data['model'] = $this->service->getEntityModel((int)($dataGet['id'] ?? null));
        $data['dataProvider'] = $this->service->getDataProvider();

        return $this->render('index', $data);
    }
}
