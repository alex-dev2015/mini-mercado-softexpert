import {Box, Col, Content, Row, Button} from "adminlte-2-react";

import './sytles.css';
import {useEffect, useRef, useState} from "react";
import api from "../../services/api";

const Sale = () => {

    const [productId, setProductId] = useState('');
    const [quantity, setQuantity] = useState(1);
    const [inputValue, setInputValue] = useState('');
    const inputRef = useRef(null);
    const inputQuantity = useRef(null);
    const [dadosProdutos, setDadosProdutos] = useState([
        {
            'id': 0,
            'product_name': '',
            'price': 0
        }
    ]);

    const [listItemSale, setItemSale] = useState([
        {
            'sales': [
                {
                    'product_id' : 0,
                    'unitary_value' : 0,
                    'quantity' : 0,
                    'amount' : 0
                }
            ]
        }
    ]);

    const handleSearch = async () => {
        await api.get(`products/${inputValue}`)
            .then((response) => {
                let result = response.data.dados;
                console.log(result);
                if (result.length === 0)
                {

                    setDadosProdutos('');
                    alert('Produto não encontrado!');
                }
                else
                {
                    setDadosProdutos(response.data.dados)
                    inputRef.current.focus();
                }
            })
            .catch((error) => {
                alert('Erro ao carregar: \n' + error.response.data.mensagem)
            })
    }

    const handleKeyPress = (event) => {
        if (event.key === "Enter") {
           setProductId(event.target.value);
           handleSearch();
        }
    }

    const handleClearInput = (event) => {
        setInputValue('');
    };

    const amountItem = quantity * dadosProdutos[0].price;

    function handleQuantityChange(event) {
        setQuantity(event.target.value);
    }

    return (
        <Content title="Página de Vendas" homeRoute="/home" subTitle="Mini Mercado SofExpert" browserTitle="SoftExpert">
            <Row>
                <Col md={7}>
                    <Box title="Página de Vendas" type="success"
                         footer={<Button type="success" pullRight="alignRight" text="Adicionar Item"/>}>
                        <div className="card-body">
                            <div className="form-group-lg">
                                <input
                                    type="text"
                                    className="form-control largeColumn"
                                    name="id"
                                    id="id"
                                    placeholder="Código do Produto"
                                    value={inputValue}
                                    onChange={(e) => setInputValue(e.target.value)}
                                    onFocus={handleClearInput}
                                    onKeyPress={handleKeyPress}
                                />
                            </div>
                        </div>
                        <div className="card-body">
                            <div className="form-group-lg">
                                <input
                                    type="text"
                                    className=" largeColumn"
                                    name="product_name"
                                    id="product_name"
                                    readOnly
                                    placeholder="Descrição do Produto"
                                    value={dadosProdutos[0].product_name}
                                />
                            </div>
                        </div>
                        <div className="card-body">
                            <div className="form-group-lg">
                                <input
                                    type="text"
                                    pattern="[0-9]+"
                                    title="Por favor, insira apenas números"
                                    className=" largeColumn"
                                    id="quantity"
                                    name="quantity"
                                    value={quantity}
                                    onChange={handleQuantityChange}
                                    ref={inputRef}
                                    placeholder="Quantidade"
                                />
                            </div>
                        </div>
                        <div className="card-body">
                            <div className="form-group-lg">
                                <input
                                    type="text"
                                    readOnly
                                    className="largeColumn"
                                    id="unitary_value"
                                    name="unitary_value"
                                    placeholder="Preço"
                                    value={dadosProdutos[0].price}
                                />
                            </div>
                        </div>
                        <div className="card-body">
                            <div className="form-group-lg">
                                <input
                                    type="text"
                                    disabled
                                    className="largeColumn"
                                    id="amount"
                                    name="amount"
                                    ref={inputQuantity}
                                    placeholder="Sub-Total"
                                    value={amountItem.toFixed(2)}
                                />
                            </div>
                        </div>

                    </Box>

                </Col>
                <Col md={5}>
                    <Box>
                        <ul>
                            <li>

                            </li>
                        </ul>
                    </Box>
                </Col>
            </Row>
        </Content>);
}

export default Sale;