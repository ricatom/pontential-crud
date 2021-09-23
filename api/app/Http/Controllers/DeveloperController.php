<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DeveloperRepository;
use Illuminate\Support\Facades\Validator;

class DeveloperController extends Controller
{
    protected $developerRepository;


    public function __construct(DeveloperRepository $developerRepository)
    {
        parent::__construct();

        $this->developerRepository = $developerRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $per_page = $request->filled('per_page') ? $params['per_page'] : 10;

        if ($request->filled('q')) {
            $q = $params['q'];
            $where = [["nome", "like", "%$q%"]];
            $this->developerRepository->where($where);
        }

        $developers = $this->developerRepository->select(['id', 'nome', 'sexo', 'idade', 'hobby', 'datanascimento'])
            ->getAll($per_page);

        if (count($developers->getCollection()) == 0) {
            return $this->respond->not_found();
        }

        return response($developers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $rules = array(
            'nome' => 'required|max:255',
            'sexo' => 'nullable|max:1',
            'idade' => 'nullable|integer',
            'hobby' => 'nullable|max:255',
            'datanascimento' => 'nullable|date'
        );
        $messages = array(
            'nome.required' => 'Informe o nome.'
        );

        $validator = Validator::make($data, $rules, $messages);

        if (!$validator->passes()) { //validação falhou
            return $this->respond->form_data_invalid([], $validator->messages());
        }

        $created = $this->developerRepository->create($data);

        if (!$created) {
            return $this->respond->badRequest();
        }

        return $this->respond->created($created);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $developer = $this->developerRepository->findByID($id);

        if (!$developer) {
            return $this->respond->not_found();
        }

        return response($developer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $developer = $this->developerRepository->findByID($id);

        if (!$developer) {
            return $this->respond->not_found();
        }

        $data = $request->all();

        $rules = array(
            'nome' => 'required|max:255',
            'sexo' => 'nullable|max:1',
            'idade' => 'nullable|integer',
            'hobby' => 'nullable|max:255',
            'datanascimento' => 'nullable|date'
        );
        $messages = array(
            'nome.required' => 'Informe o nome.'
        );

        $validator = Validator::make($data, $rules, $messages);

        if (!$validator->passes()) { //validação falhou
            return $this->respond->form_data_invalid([], $validator->messages());
        }

        $updated = $this->developerRepository->update($developer, $data);

        if (!$updated) {
            return $this->respond->badRequest();
        }

        return $this->respond->updated();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $developer = $this->developerRepository->findByID($id);

        if (!$developer) {
            return $this->respond->not_found();
        }

        $deleted = $this->developerRepository->delete($developer);

        if (!$deleted) {
            return $this->respond->badRequest();
        }

        return $this->respond->deleted();
    }
}
