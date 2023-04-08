import {Box, Col, Content, Row, Button} from "adminlte-2-react";
import MyTable from "../../Components/MyTable";
import {useEffect, useState} from "react";
import api from "../../services/api";

const Produto = () => {
    const [dadosProdutos, setDadosProdutos] = useState([
        {
            'id': 0,
            'product_name': '',
            'price': 0,
            'type_id': 0
        }
    ]);

    const headers = [
        {chave: "id", nome: "#"},
        {chave: "product_name", nome: "Produtos"},
        {chave: "price", nome: "Preço"},
    ];

    const [optionTypeProduct, setOptionTypeProduct] = useState([]);

    useEffect(() => {
        api.get('product_type')
            .then((response) => {
                setOptionTypeProduct(response.data.dados)
            })
            .catch((error) => {
                console.error(error);
            })

    }, []);

    useEffect(() => {
        api.get('products')
            .then((response) => {
                setDadosProdutos(response.data.dados)
            })
            .catch((error) => {
                console.error(error.response.data);
                alert('Erro ao carregar: \n' + error.response.data.message)
            })
    }, [])

    return (<Content title="Página de Produtos" homeRoute="/home" subTitle="SoftExpert" browserTitle="Soft|EXPERT">
        <Row>
            <Col xs={6}>
                <Box title="Produtos" type="info">
                    <MyTable headers={headers} data={dadosProdutos}/>
                </Box>
            </Col>
            <Col xs={6}>
                <Box title="Cadastro" type="primary">
                    <form>
                        <div className="card-body">
                            <div className="form-group">
                                <label htmlFor="nome">Tipo de Produto</label>
                                <select className="form-control">
                                    {optionTypeProduct.map(opcao => (
                                        <option key={opcao.id} value={opcao.id}>{opcao.product_type_name}</option>
                                    ))}
                                </select>
                            </div>

                            <div className="form-group">
                                <label htmlFor="product_name">Descrição</label>
                                <input type="text" className="form-control" id="product_name"
                                       placeholder="Descrição Tipo de Produto"/>
                            </div>
                            <div className="form-group">
                                <label htmlFor="price">Valor</label>
                                <input type="text"  className="form-control" id="price"
                                       placeholder="1.500"/>
                            </div>
                        </div>
                        <div className="card-footer">
                            <button type="submit" className="btn btn-primary">Gravar</button>
                        </div>
                    </form>
                </Box>
            </Col>
        </Row>
    </Content>);
}

export default Produto;