<?php

namespace app\services\employee;

use Yii;
use yii\db\Transaction;
use app\models\employee\Employee;
use yii\data\ActiveDataProvider;

/**
 * Class EmployeeService
 *
 * @package app\services\employee
 */
class EmployeeService
{
    /**
     * @param int|null $id
     * @param bool     $useMake
     *
     * @return Employee|null
     * @author sihoullete
     */
    public function getEntityModel(int $id = null, bool $useMake = true): ?Employee
    {
        $entityModel = Employee::find()->where(['id' => $id])->one();
        if ($useMake && !$entityModel instanceof Employee) {
            $entityModel = new Employee();
        }

        return $entityModel;
    }

    /**
     * @param array $data
     *
     * @return ActiveDataProvider
     * @author sihoullete
     */
    public function getDataProvider(array $data = []): ActiveDataProvider
    {
        $query = Employee::find()->joinWith(['rank']);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);
    }

    /**
     * @param array $data
     *
     * @return array
     * @author sihoullete
     */
    public function create(array $data = []): array
    {
        $entityModel = $this->getEntityModel();

        return $this->callSave($entityModel, $data);
    }

    /**
     * @param int   $id
     * @param array $data
     *
     * @return array
     * @author sihoullete
     */
    public function update(int $id, array $data = []): array
    {
        $entityModel = $this->getEntityModel($id);

        return $this->callSave($entityModel, $data);
    }

    /**
     * @param int $id
     *
     * @return array
     * @author sihoullete
     */
    public function delete(int $id): array
    {
        $entityModel = $this->getEntityModel($id, false);

        return $this->callDelete($entityModel);
    }

    /**
     * @param Employee $entityModel
     * @param array    $data
     *
     * @return array
     * @author sihoullete
     */
    protected function callSave(Employee $entityModel, array $data = []): array
    {
        $resp['success'] = false;
        $entityModel->load($data);
        if ($entityModel->validate()) {
            /** @var Transaction $transaction */
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $entityModel->save();
                $transaction->commit();
                $resp['data'] = $entityModel->getAttributes();
                $resp['success'] = true;
            } catch (\Exception $e) {
                //TODO Write exception to log
                $resp['success'] = false;
                $transaction->rollBack();
            }
        } else {
            $resp['errors'] = $entityModel->getErrors();
        }

        return $resp;
    }

    /**
     * @param Employee|null $entityModel
     *
     * @return array
     * @author sihoullete
     */
    protected function callDelete(Employee $entityModel = null): array
    {
        $resp['success'] = false;
        if ($entityModel instanceof Employee) {
            /** @var Transaction $transaction */
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $entityModel->delete();
                $transaction->commit();
                $resp['success'] = true;
            } catch (\Exception $e) {
                //TODO Write exception to log
                $resp['success'] = false;
                $transaction->rollBack();
            }
        }

        return $resp;
    }
}
