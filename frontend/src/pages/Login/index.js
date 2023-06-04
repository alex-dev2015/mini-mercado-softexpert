import React, { useState } from 'react';
import api from "../../services/api";

const Login = ({ onLogin }) => {
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const credentials = {
        username,
        password
    };

    const handleUsernameChange = (e) => {
        setUsername(e.target.value);
    };

    const handlePasswordChange = (e) => {
        setPassword(e.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        setIsSubmitting(true);
        api.post('login', credentials)
            .then(response => {
                sessionStorage.setItem('session', response.data.dados);
                setIsSubmitting(false);
                onLogin();
            })
            .catch(error => {
                setIsSubmitting(false);
                alert('Falha ao executar o Login: ')
            });
    };

    return (
        <div className="login-box">
            <div className="login-logo">
                <a href="/">
                    {/* Inserir logotipo aqui */}
                </a>
            </div>
            <div className="login-box-body">
                <p className="login-box-msg">Faça login para iniciar sua sessão</p>

                <form onSubmit={handleSubmit}>
                    <div className="form-group has-feedback">
                        <input
                            type="text"
                            className="form-control"
                            placeholder="Usuário"
                            value={username}
                            onChange={handleUsernameChange}
                        />
                        <span className="glyphicon glyphicon-user form-control-feedback" />
                    </div>
                    <div className="form-group has-feedback">
                        <input
                            type="password"
                            className="form-control"
                            placeholder="Senha"
                            value={password}
                            onChange={handlePasswordChange}
                        />
                        <span className="glyphicon glyphicon-lock form-control-feedback" />
                    </div>
                    <div className="row">
                        <div className="col-xs-12">
                            <button
                                type="submit"
                                className="btn btn-primary btn-block btn-flat"
                                disabled={isSubmitting}
                            >
                                {isSubmitting ? 'Autenticando...' : 'Entrar'}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default Login;
