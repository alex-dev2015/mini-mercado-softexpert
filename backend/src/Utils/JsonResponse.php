<?php

namespace App\Utils;

class JsonResponse
{
    protected bool $success;
    protected mixed $responseContent;
    protected int $httpStatusCode;
    protected ?string $errorMessage;
    protected ?string $returnMessage;

    public function __construct()
    {
        $this->errorMessage = null;
        $this->returnMessage = null;
        $this->responseContent = [];
        $this->setSuccess(true);
        $this->setHttpStatusCode(200);
    }

    public function getResponse() : mixed
    {
        $responseContent = [
            'sucesso' => $this->success,
            'mensagem' => $this->returnMessage,
            'dados' =>  $this->responseContent,
            'erro' => $this->errorMessage,
        ];

        return $responseContent;
    }

    /**
     * @param bool $success
     */
    public function setSuccess(bool $success): bool
    {
        return $this->success = $success;
    }

    /**
     * @param mixed $responseContent
     */
    public function setResponseContent(mixed $responseContent): self
    {
        $this->responseContent = $responseContent;
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
     * @param string|null $errorMessage
     */
    public function setErrorMessage(?string $errorMessage): self
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    /**
     * @param string|null $returnMessage
     */
    public function setReturnMessage(?string $returnMessage): self
    {
        $this->returnMessage = $returnMessage;
        return $this;
    }

}
