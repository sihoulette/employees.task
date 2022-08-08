<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\base\Module as BaseModule;
use app\services\employee\EmployeeService;
use yii\web\Response;

/**
 * Class EmployeeController
 *
 * @package app\controllers
 */
class EmployeeController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @return Response
     * @author sihoullete
     */
    public function actionCreate(): Response
    {
        $resp['success'] = false;
        $this->response->format = Response::FORMAT_JSON;
        if ($this->request->isAjax && $this->request->isPost) {
            $resp = $this->service->create($this->request->post());
            if (!$resp['success'] && !empty($resp['errors'] ?? [])) {
                Yii::$app->session->setFlash('error', $resp['errors']);
            }
        }
        $this->response->data = $resp;

        return $this->response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int|null $id
     *
     * @return Response
     * @author sihoullete
     */
    public function actionUpdate(int $id = null): Response
    {
        $resp['success'] = false;
        $this->response->format = Response::FORMAT_JSON;
        if ($this->request->isAjax && $this->request->isPost) {
            $resp = $this->service->update($id, $this->request->post());
            if (!$resp['success'] && !empty($resp['errors'] ?? [])) {
                Yii::$app->session->setFlash('error', $resp['errors']);
            }
        }
        $this->response->data = $resp;

        return $this->response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int|null $id
     *
     * @return Response
     * @author sihoullete
     */
    public function actionDelete(int $id = null): Response
    {
        $resp['success'] = false;
        $this->response->format = Response::FORMAT_JSON;
        if ($this->request->isAjax && $this->request->isPost) {
            $resp = $this->service->delete($id);
            if (!$resp['success'] && !empty($resp['errors'] ?? [])) {
                Yii::$app->session->setFlash('error', $resp['errors']);
            }
        }
        $this->response->data = $resp;

        return $this->response;
    }
}
