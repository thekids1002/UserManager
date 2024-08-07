<?php

namespace App\Repositories;

use App\Libs\ValueUtil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Traits\Loggable;
abstract class BaseRepository
{
    protected $model;
    protected $validDelFlg;
    use Loggable;
    public function __construct()
    {
        $this->setModel();
        $this->validDelFlg = ValueUtil::constToValue('common.del_flg.VALID');
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Find by id
     *
     * @param string|int $id
     * @param bool $isFindAll
     * @param string|null $loggingChannel
     * @return object|bool
     */
    public function findById($id, $isFindAll = false) {
        try {
            if(!is_numeric($id)){
                return false;
            }
            $query = $this->model->where($this->model->getKeyName(), $id);
            if (!$isFindAll) {
                $query->whereNull('deleted_date');
            }
            return $query->first();
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
    }

    /**
     * Insert or update record if id exist, return true if success and false if not
     *
     * @param null|int $id
     * @param array $params
     *
     * @return mixed
     */
    public function save($id = null, $params, $isFindAll = false)
    {
        try {
            DB::beginTransaction();
            if ($id) {
                $result = $this->findById($id, $isFindAll);
                $result->fill($params);
                $result = $result->save();
            } else {
                $result = $this->model->create($params);
            }
            if (!$result){
                DB::rollBack();
            }
            DB::commit();
            return $result;
        } catch (\Exception $th) {
            $this->logError($th);
            DB::rollBack();
            return false;
        }

    }

    /**
     * Insert or update multiple record if id exist, return true if success and false if not
     *
     * @param null|array $ids
     * @param array $attributes
     *
     * @return mixed
     */
    public function saveMany($ids = null, $attributes)
    {
        try {
            DB::beginTransaction();
            $models = [];

            foreach ($attributes as $index => $attribute) {
                $id = $ids[$index];

                if ($id) {
                    $model = $this->model->find($id);
                    $model = $model->update($attribute);
                }
                else {
                    $model = $this->model->save($attribute);
                }
                if (!$model){
                    DB::rollBack();
                }
                $models[] = $model;
            }
            DB::commit();
            return $models;
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            return false;
        }
    }
}
