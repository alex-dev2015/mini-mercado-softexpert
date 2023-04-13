import React, { Component } from 'react';
import AdminLTE, { Sidebar } from 'adminlte-2-react';

import Home from './pages/Home';
import Sale from "./pages/Sale";
import Produto from "./pages/Produto";
import TipoProduto from "./pages/TipoProduto";

import UsuarioImg from './assets/image/user.png'

const { Item, UserPanel } = Sidebar;

class App extends Component {

  sidebar = [
    <UserPanel username='Alex Nascimento' key="username" imageUrl={UsuarioImg} status='online' />,
    <Item key="home" text="Home" to="/home" />,
    <Item icon='fa-inbox' key="tipo_produtos" text="Tipo de Produtos" to="/tipo_produtos" />,
    <Item icon='fa-box' key="produtos" text="Produtos" to="/produtos" />,
    <Item icon='fa-shopping-cart' key="sales" text="Vendas" to="/sales" />,
  ]

  render() {
    return (
      <AdminLTE title={["Soft", "Expert"]} titleShort={["He", "we"]} theme="red" sidebar={this.sidebar}>
        <Home path="/home" />
        <Produto path="/produtos" />
        <Sale path="/sales" />
        <TipoProduto path="/tipo_produtos" />
      </AdminLTE>
    );
  }
}

export default App;