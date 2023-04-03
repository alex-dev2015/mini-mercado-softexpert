<?php

namespace App\Utils;

class JsonResponse
{
    protected bool $sucesso;
    protected mixed $conteudoResposta;
    protected int $httpStatusCode;
    protected ?string $mensagemDeErro;
    protected ?string $mensagemDeRetorno;

    public function __construct()
    {
        $this->mensagemDeErro = null;
        $this->mensagemDeRetorno = null;
        $this->conteudoResposta = [];
        $this->setSucesso(true);
        $this->setHttpStatusCode(200);
    }

    public function getResponse()
    {
        $conteudoResposta = [
            'sucesso' => $this->sucesso,
            'mensagem' => $this->mensagemDeRetorno,
            'dados' =>  $this->conteudoResposta,
            'erro' => $this->mensagemDeErro,
        ];

        return $conteudoResposta;
    }


    /**
     * @param bool $sucesso
     */
    public function setSucesso(bool $sucesso): bool
    {
        return $this->sucesso = $sucesso;
    }

    /**
     * @param mixed $conteudoResposta
     */
    public function setConteudoResposta(mixed $conteudoResposta): self
    {
        $this->conteudoResposta = $conteudoResposta;
        return $this;
    }

    /**
     * @param int $httpStatusCode
     */
    public function setHttpStatusCode(int $httpStatusCode): self
    {
        $this->httpStatusCode = $httpStatusCode;
        http_response_code($httpStatusCode);
        return $this;
    }

    /**
     * @param string|null $mensagemDeErro
     */
    public function setMensagemDeErro(?string $mensagemDeErro): self
    {
        $this->mensagemDeErro = $mensagemDeErro;
        return $this;
    }

    /**
     * @param string|null $mensagemDeRetorno
     */
    public function setMensagemDeRetorno(?string $mensagemDeRetorno): self
    {
        $this->mensagemDeRetorno = $mensagemDeRetorno;
        return $this;
    }

}