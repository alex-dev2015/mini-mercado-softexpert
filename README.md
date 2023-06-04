<h1>Mercado SoftExpert </h1>
<p> Sejam bem-vindos ao projeto teste que simula as transações básicas de um mini mercado, esse proejeto foi desenvolvido sem ajuda de Framework, usando apenas POO com PDO e o Padrão de Projetos Singleton .<br>

## Índice

- [Objetivo](#objetivo)
- [Pré-requisitos](#requisitos)
- [Executando o Projeto](#usage)
- [Frontend](#front)
- [Tecnologias Utilizadas](#utils)
- [Links](#links)
- [Licença](#license)
- [Autor](#autor)

## 🎯 Objetivo do Projeto <a name = "objetivo"></a>

<p>O projeto trata-se de uma <strong>API REST</strong> foi usada uma biblioteca apenas para auxiliar as requisições, chamada <strong>FastRouter</strong> o restante foi todo feito Orientado a Objetos, usando alguns pilares como encapsulamento e polimorfismo. Além disso, ao iniciar o container, as tabelas serão geradas automaticamente. Existem duas pastas, uma do frontend e outra do backend.</p>

## 🛑 Pré-requistos para rodar o Projeto <a name = "requisitos"></a>

- [x] GIT
- [x] Docker
- [x] PHP > 7.4
- [x] NodeJS

## Executando o Projeto <a name = "usage"></a>

Para ter uma cópia do projeto, basta realizar o clone deste repositório e prosseguir com os passos seguintes.
```
  git clone https://github.com/alex-dev2015/mini-mercado-softexpert
```

Após do Download, entrar na pasta do projeto seguidamente na pasta postgresql para executar o docker.
```
 cd backend
 cd postgresql
```
Executando o docker

```
  docker-compose up -d --build
```

Após o subir o servidor, volte um nível e instale as dependências do projeto
```
  cd..
  composer install    
```

Agora suba o servidor local do PHP, caso não consiga, isso significa que o seu PHP não está configurado de forma global.
```
  php -S localhost:8080  
```

## Atenção
Na raíz do projeto possui um arquivo chamado <b>.env</b> contendo as configurações das variáveis de ambiente. Por padrão o arquivo  não é exposto em repositórios, o ideal seria ter uma cópia de exemplo,
mas como nesse projeto já tenho as configurações de acesso ao banco de dados definida, houve a necessidade de fazer dessa forma.


## Frontend <a name = "front"></a>

No diretório chamado frontend, econtra-se o código desenvolvido, o build para executar o projeto diretamente pelo navegador
e um arquivo Readme explicando os passos para executar o projeto.


## 🛠 Tecnologias Utilizadas</h2> <a name = "utils"></a>

<ul>
    <li>IDE IntelliJ</li>
    <li>PHP 8.1</li>
    <li><strong>Docker</strong></li>
    <li><strong>React</strong></li>
    <li>NodeJS</li>
    <li>Insomnia</li>
</ul>


## 🔗 Links Úteis <a name = "links"></a>
<ul>
    <li><a href="https://react.dev/">React</a></li>
    <li><a href="https://insomnia.rest/download">Insomnia</a></li>
    <li><a href="https://www.docker.com/">Docker</a></li>
</ul>


## 📜 Licença <a name = "license"></a>

Este projeto está sob licença MIT. Veja o arquivo [LICENSE](LICENSE.md) para mais detalhes.

## ✍️Autor <a name = "autor"></a>

<a href="https://github.com/alex-dev2015" target="_blank">Alex Sousa</a>

&#xa0;

<a href="#top">Voltar para o topo</a>

------------






