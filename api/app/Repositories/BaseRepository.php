<?php

namespace App\Repositories;


abstract class BaseRepository
{
    protected $modelClass;
    protected $with = [];
    protected $select;
    protected $where;
    protected $trashed = false;


    public function getAll(int $take = 15, bool $paginate = true)
    {
        return $this->doQuery(null, $take, $paginate);
    }


    public function findByID(int $id, bool $fail = false)
    {
        if ($fail) {
            return $this->newQuery()->findOrFail($id);
        }

        return $this->newQuery()->find($id);
    }


    public function save($model)
    {
        return $model->save();
    }


    public function create(array $data = [])
    {
        $model = $this->factory($data);
        $this->save($model);

        return $model;
    }


    public function update($model, array $data = [])
    {
        $this->setModelData($model, $data);

        return $this->save($model);
    }


    public function delete($model, bool $force = false)
    {
        if ($force) {
            return $model->forceDelete();
        }

        return $model->delete();
    }


    public function deleteAll($collection, bool $force = false)
    {
        return $collection->each(function ($item) use ($force) {
            if ($force) {
                return $item->forceDelete();
            }

            return $item->delete();
        });
    }

    

    public function select($value = null)
    {
        $this->select = $value;

        return $this;
    }
    
    public function where(array $where = [])
    {
        $this->where = $where;

        return $this;
    }


    public function with(array $data = [])
    {
        $this->with = $data;

        return $this;
    }



    public function onlyTrashed()
    {
        $this->trashed = 'only';

        return $this;
    }


    public function withTrashed()
    {
        $this->trashed = 'with';

        return $this;
    }


    public function withoutTrashed()
    {
        $this->trashed = false;

        return $this;
    }


    protected function newQuery()
    {
        $query = app()->make($this->modelClass)->newQuery();

        if ('only' === $this->trashed) {
            $query->onlyTrashed();
        }

        if ('with' === $this->trashed) {
            $query->withTrashed();
        }


        if (!empty($this->with)) {
            $query->with($this->with);
        }

        if (!empty($this->select)) {
            $query->select($this->select);
        }
        
        if (!empty($this->where)) {
            $query->where($this->where);
        }

        return $query;
    }


    protected function doQuery($query = null, int $take = 15, bool $paginate = true)
    {
        if (is_null($query)) {
            $query = $this->newQuery();
        }

        if (true == $paginate) {
            return $query->paginate($take);
        }

        if ($take > 0 || false !== $take) {
            $query->take($take);
        }

        return $query->get();
    }


    protected function factory(array $data = [])
    {
        $model = $this->newQuery()->getModel()->newInstance();

        $this->setModelData($model, $data);

        return $model;
    }


    protected function setModelData($model, array $data)
    {
        return $model->fill($data);
    }
}
