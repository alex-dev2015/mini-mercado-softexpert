import React, { useEffect, useState} from 'react';
import AdminLTE, {Sidebar} from 'adminlte-2-react';

import Login from "./pages/Login";
import Home from './pages/Home';
import Sale from "./pages/Sale";
import Produto from "./pages/Produto";
import TipoProduto from "./pages/TipoProduto";

import UsuarioImg from './assets/image/user.png'
import api from "./services/api";

const {Item, UserPanel} = Sidebar;

const App = () => {

    const [isAuthenticated, setIsAuthenticated] = useState(false);
    const [user, setUser] = useState('');


    useEffect(() => {
        const authSession = 'Bearer '+sessionStorage.getItem('session');
        api.get('authenticate', {
            headers: {
                "Authorization" : authSession
            }
        }).then((result) => {
            const loggedIn = sessionStorage.getItem('login') === 'true';
            setUser(result.data.email);
            setIsAuthenticated(loggedIn);
        }).catch((error) => {
            console.log(error);
        })
    }, []);

    const handleLogin = () => {
        sessionStorage.setItem('login', 'true');
        setIsAuthenticated(true);
    };

     const sidebar = [
        <UserPanel username={user} key="username" imageUrl={UsuarioImg} status='online'/>,
        <Item key="home" text="Home" to="/home"/>,
        <Item icon='fa-inbox' key="tipo_produtos" text="Tipo de Produtos" to="/tipo_produtos"/>,
        <Item icon='fa-box' key="produtos" text="Produtos" to="/produtos"/>,
        <Item icon='fa-shopping-cart' key="sales" text="Vendas" to="/sales"/>,
    ]

    return (
        <div className="wrapper">
            {isAuthenticated ? (
                <AdminLTE title={['Soft', 'Expert']} titleShort={['He', 'we']} theme="red" sidebar={sidebar}>
                    <Home path="/home"/>
                    <Produto path="/produtos"/>
                    <Sale path="/sales"/>
                    <TipoProduto path="/tipo_produtos"/>
                </AdminLTE>
            ) : (
                <Login onLogin={handleLogin}/>
            )}
        </div>
    );

}

export default App;