<?php

namespace App\Support\Http;

use Illuminate\Http\JsonResponse as Response;

const SUCCESS_STATUS = 'success';
const NOT_FOUND_STATUS = 'not_found';
const TOKEN_REQUIRED = 'token_required';
const MEMBER_NOT_FOUND = 'member_not_found';
const INPUT_IS_REQUIRED = 'input_required';
const INVALID_FORM_DATA = 'invalid_form_data';
const INVALID_APP_KEY = 'invalid_app_key';
const UNAUTHORIZED_STATUS = 'unauthorized';//Unauthorized
const ACCEPTED_STATUS = 'accepted';//Aceito
const DELETED_STATUS = 'deleted';//Deletado
const UPDATED_STATUS = 'updated';//Atualizado
const CREATED_STATUS = 'created';//Criado
const OK_STATUS = 'ok';//OK
const FORBIDDEN_STATUS = 'forbidden';//proibido
const BAD_REQUEST = 'bad request';



class Respond
{


    /**
     * OK
     *
     * @param array $data
     * @param string $msg
     * @return void
     */
    public function ok($data = [], $msg = '')
    {
        return $this->respond($data, Response::HTTP_OK, $this->format($msg, Response::HTTP_OK, OK_STATUS));
    }


    /**
     * Criado
     *
     * @param array $data
     * @param string $msg
     * @return void
     */
    public function created($data = [], $msg = '')
    {
        return $this->respond($data, Response::HTTP_CREATED, $this->format($msg, Response::HTTP_CREATED, CREATED_STATUS));
    }


    /**
     * Atualizado
     *
     * @param string $msg
     * @return void
     */
    public function updated($data = [], $msg = '')
    {
        // return $this->respond($data, Response::HTTP_ACCEPTED, $this->format($msg, Response::HTTP_ACCEPTED, UPDATED_STATUS));
        return $this->respond($data, Response::HTTP_OK, $this->format($msg, Response::HTTP_OK, UPDATED_STATUS));
    }
    

    /**
     * Aceito
     *
     * @param string $msg
     * @return void
     */
    public function accepted($data = [], $msg = '')
    {
        return $this->respond($data, Response::HTTP_ACCEPTED, $this->format($msg, Response::HTTP_ACCEPTED, ACCEPTED_STATUS));
    }


    /**
     * Deletado
     *
     * @param string $msg
     * @return void
     */
    public function deleted($msg = '')
    {
        return $this->respond([], Response::HTTP_OK, $this->format($msg, Response::HTTP_OK, DELETED_STATUS));
    }


    /**
     * Não autorizado.
     *
     * @param string $msg
     * @return void
     */
    public function unauthorized($msg = 'Não autorizado')
    {
        return $this->respond([], Response::HTTP_UNAUTHORIZED, $this->format($msg, Response::HTTP_UNAUTHORIZED, UNAUTHORIZED_STATUS));
    }
    

    /**
     * Dados não encontrados.
     *
     * @param string $msg
     * @return void
     */
    public function not_found($msg = 'Dados não encontrados.')
    {
        return $this->respond([], Response::HTTP_NOT_FOUND, $this->format($msg, Response::HTTP_NOT_FOUND, NOT_FOUND_STATUS));
    }

    /**
     * Usuário não encontrado
     *
     * @param string $msg
     * @return void
     */
    public function member_not_found($msg = 'Usuário e/ou senha são inválidos. Verifique.')
    {
        return $this->respond([], Response::HTTP_NOT_FOUND, $this->format($msg, Response::HTTP_NOT_FOUND, MEMBER_NOT_FOUND));
    }


    /**
     * Dados não encontrados.
     *
     * @param string $msg
     * @return void
     */
    public function forbidden($msg = 'Acesso ao recurso solicitado não é permitido.')
    {
        return $this->respond([], Response::HTTP_FORBIDDEN, $this->format($msg, Response::HTTP_FORBIDDEN, FORBIDDEN_STATUS));
    }

    /**
     * Entrada necessária.
     *
     * @param array $data
     * @return void
     */
    function input_is_required($data = [])
    {
        return $this->respond([], Response::HTTP_UNPROCESSABLE_ENTITY, $this->format('Entrada necessária.', Response::HTTP_UNPROCESSABLE_ENTITY, INPUT_IS_REQUIRED, $data));
    }


    /**
     * Token necessário.
     *
     * @return void
     */
    function token_required()
    {
        return $this->respond([], Response::HTTP_NON_AUTHORITATIVE_INFORMATION, $this->format('Token necessário.', Response::HTTP_NON_AUTHORITATIVE_INFORMATION, TOKEN_REQUIRED));
    }

    /**
     * APP KEY inválida.
     *
     * @return void
     */
    function app_key_invalid()
    {
        return $this->respond([], Response::HTTP_FORBIDDEN, $this->format('APP KEY inválida.', Response::HTTP_FORBIDDEN, INVALID_APP_KEY));
    }

    /**
     * Dados do formulário inválido
     *
     * @param array $data
     * @param string $msg
     * @return void
     */
    function form_data_invalid($data = [], $msg = 'Dados do formulário inválido')
    {
        return $this->respond([], Response::HTTP_UNPROCESSABLE_ENTITY, $msg);
    }

    function badRequest($msg = 'Bad Request')
    {
        return $this->respond([], Response::HTTP_BAD_REQUEST, $this->format($msg, Response::HTTP_BAD_REQUEST, BAD_REQUEST));
    }    

    /**
     * Responde
     *
     * @param [type] $data
     * @param [type] $code
     * @param array $error
     * @param [type] ...$meta
     * @return void
     */
    protected function respond($data, $code, $res = null, ...$meta)
    {
        $response = [];

        if (!empty($res)) {
            $response['res'] = $res;
        }            

        if (!empty($data)) {
            $response['data'] = $data;
        }            

        if (!empty($meta)) {
            $response['meta'] = array_collapse($meta);
        }

        return new Response($response, $code);
    } 
    

    /**
     * Formata os dados
     *
     * @param string $message
     * @param integer $code
     * @param string $type
     * @param [type] ...$data
     * @return void
     */
    protected function format(string $message, int $code, string $type, ...$data)
    {
        $error_response = [
            "message" => $message,
            "code" => $code,
            "type" => $type
        ];

        $error_response = !empty($data) ? array_merge($error_response, array_collapse($data)) : $error_response;

        return $error_response;
    }
}
