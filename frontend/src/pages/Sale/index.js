import {useEffect, useRef, useState} from "react";
import {Box, Col, Content, Row, Button} from "adminlte-2-react";

import api from "../../services/api";

import './sytles.css';
import MyTable from "../../Components/MyTable";
import {formatCurrency, stringToFloat} from "../../utils/globalFunctions";

const Sale = () => {

    const [showContainer, setShowContainer] = useState(false);
    const [showContainerSale, setShowContainerSale] = useState(false);
    const [productId, setProductId] = useState('');
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [enableNewSale, setEnableNewSale] = useState(false);
    const [enableFinishSale, setEnableFinishSale] = useState(false);
    const [ultimateNumber, setUltimateNumber] = useState(0);
    const [quantity, setQuantity] = useState('');
    const [inputValue, setInputValue] = useState('');
    const inputRef = useRef(null);
    const formRef = useRef(null);
    const inputQuantity = useRef(null);
    const [sales, setSales] = useState({})
    const [valueTotal, setValueTotal] = useState(0);
    const [dataProducts, setDataProducts] = useState([
        {
            'id': '',
            'product_name': '',
            'price': ''
        }
    ]);
    const [responseDataSale, setResponseDataSale] = useState({
        amountSales: 0,
        amountTaxes: 0,
        items: [
            {
                product_id: 0,
                product_name: '',
                unitary_value: 0,
                quantity: 0,
                amount: 0,
                tax: 0
            }
        ]
    });


    const headers = [
        {chave: "item", nome: "Item"},
        {chave: "product_id", nome: "Cod. Produto"},
        {chave: "product_name", nome: "Produto"},
        {chave: "unitary_value", nome: "Vlr. Unit."},
        {chave: "quantity", nome: "Qnt."},
        {chave: "amount", nome: "Valor"},
    ];

    const alignments = {
        item: "center",
        product_id: "center",
        product_name: "left",
        unitary_value: "right",
        quantity: "center",
        amount: "right",
    };

    const headersResume = [
        {chave: "product_id", nome: "Cod."},
        {chave: "product_name", nome: "Produto"},
        {chave: "unitary_value", nome: "Valor Unt."},
        {chave: "quantity", nome: "Qnt"},
        {chave: "amount", nome: "Total"},
        {chave: "tax", nome: "Imposto"},
    ];

    const alignmentsResume = {
        product_id: "center",
        product_name: "left",
        unitary_value: "center",
        quantity: "center",
        amount: "right",
        tax: "right"
    };

    const [listItemsSale, setListItemsSale] = useState([
        {
            'item': '',
            'product_id': '',
            'product_name': '',
            'unitary_value': '',
            'quantity': '',
            'amount': ''
        }
    ]);

    const enableButtonNewSale = () => {
        setEnableNewSale(true);
        setEnableFinishSale(false);
        setShowContainer(false);
        setShowContainerSale(true);
        setListItemsSale([{
            'item': '',
            'product_id': '',
            'product_name': '',
            'unitary_value': '',
            'quantity': '',
            'amount': ''
        }])
    }

    const enableButtonFinishSale = () => {
        setEnableNewSale(false);
        setEnableFinishSale(true);
        setShowContainerSale(false);

    }

    const handleSearch = async () => {
        await api.get(`products/${inputValue}`)
            .then((response) => {
                let result = response.data.dados;
                if (result.length === 0) {

                    setDataProducts('');
                    alert('Produto não encontrado!');
                } else {
                    setDataProducts(response.data.dados)
                    inputRef.current.focus();
                }
            })
            .catch((error) => {
                alert('Erro ao carregar: \n' + error.response.data.mensagem)
            })
    }

    const handleKeyPress = (event) => {
        if (event.key === "Enter") {
            event.preventDefault();
            setProductId(event.target.value);
            handleSearch();
        }
    }

    const handleClearInput = (event) => {
        setInputValue('');
    };

    function handleQuantityChange(event) {
        setQuantity(event.target.value);
    }

    function nextNumber() {
        setUltimateNumber(ultimateNumber + 1);
        return ultimateNumber + 1;
    }

    const amountItem = quantity * dataProducts[0].price || 0;

    const handleAddListSale = (event) => {
        event.preventDefault();

        const form = event.target;

        const inputProductId = form.id.value;
        const inputProductName = form.product_name.value;
        const inputQuantity = form.quantity.value;
        const inputUnitaryValue = form.unitary_value.value;
        const inputAmount = form.amount.value;
        const novoItem = nextNumber();

        if (inputQuantity > 0) {
            setListItemsSale(
                [...listItemsSale, {
                    item: novoItem,
                    product_id: inputProductId,
                    product_name: inputProductName,
                    quantity: inputQuantity,
                    amount: formatCurrency(inputAmount),
                    unitary_value: formatCurrency(inputUnitaryValue)
                }
                ])

            setValueTotal( valueTotal + amountItem);

            Array.from(form).forEach(input => (input.value = ''));
            clearInputs();
            form[0].focus();
        } else {
            alert('Informe a quantidade desejada');
        }


    };

    const clearInputs = () => {
        setInputValue('');
        setQuantity('');
        setDataProducts([''])
    }


    useEffect(() => {
        if (Object.keys(sales).length !== 0) {
            const executeSale = async () => {
                try {
                    const response = await api.post('execute_sale', sales);
                    setResponseDataSale(response.data.dados);
                    setShowContainer(true);
                    enableButtonFinishSale();
                } catch (error) {
                    alert('Erro ao carregar: \n' + error.response.data.mensagem)
                }
            }
            executeSale();
        }
    }, [sales]);



    const handleSubmit = (event) => {
        event.preventDefault();
        const formattedData = listItemsSale.map((items) => {
            return {
                product_id: items.product_id,
                unitary_value: stringToFloat(items.unitary_value),
                quantity: items.quantity,
                amount: stringToFloat(items.amount)
            };
        });
        // formattedData.sort();
        formattedData.shift();
        setSales({"sales": formattedData})
    };

    return (
        <Content title="Página de Vendas" homeRoute="/home" subTitle="Mini Mercado SofExpert" browserTitle="SoftExpert">
            <Row>
                <Col md={4}>
                    <img
                        className="img-responsive"
                        src="https://greenpng.com/wp-content/uploads/2022/10/Desenho-de-carrinho-de-supermercado-1015x1024.png"
                    />
                </Col>

                <Col hidden={!showContainerSale} md={4}>
                    <form ref={formRef} onSubmit={handleAddListSale}>
                        <div className="container-sale">
                            <Box title="Produtos" type="success">
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
                                            value={dataProducts[0].product_name}
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
                                            value={dataProducts[0].price}
                                        />
                                    </div>
                                </div>
                                <div className="card-body">
                                    <div className="form-group-lg">
                                        <label>Sub-Total</label>
                                        <input
                                            type="text"
                                            disabled
                                            className="largeColumn"
                                            id="amount"
                                            name="amount"
                                            ref={inputQuantity}
                                            placeholder="Sub-Total"
                                            value={amountItem.toFixed(2) || ''}
                                        />
                                    </div>
                                </div>
                                <div className="card-body">
                                    <div className="form-group-lg">
                                        <label>Total</label>
                                        <input
                                            type="text"
                                            disabled
                                            className="largeColumn"
                                            id="valueTotal"
                                            name="valueTotal"
                                            placeholder="Total"
                                            value={formatCurrency(valueTotal)}
                                        />
                                    </div>
                                </div>
                                <button type="submit" hidden className="add-button"></button>
                            </Box>
                        </div>
                    </form>
                </Col>

                <Col hidden={!showContainerSale} md={4}>
                    <div className="container-items">
                        <Box type="info">
                            <MyTable data={listItemsSale} alignments={alignments} headers={headers}
                                     table={"table-striped"}/>
                        </Box>
                    </div>
                </Col>

                <Col hidden={!showContainer} xs={4}>
                    <Box type="danger">
                        <p className="lead">Resumo da Venda</p>
                        <MyTable
                            data={responseDataSale.items}
                            alignments={alignmentsResume}
                            headers={headersResume}
                            table="table-striped"
                        />
                        <div className="table-responsive">
                            <table className="table">
                                <tbody>
                                <tr>
                                    <th style={{"width": "50%", fontSize: "18px"}}>Total da Venda:</th>
                                    <td style={{fontSize: "18px", color: "green"}}>{responseDataSale.amountSales}</td>
                                </tr>
                                <tr>
                                    <th style={{fontSize: "18px"}}>Total dos Impostos</th>
                                    <td style={{fontSize: "18px", color: "red"}}>{responseDataSale.amountTaxes}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </Box>
                </Col>

            </Row>
            <Row>
                <Col md={12} style={{textAlign: "right"}}>
                    <button disabled={enableNewSale} onClick={enableButtonNewSale} className="btn btn-success button-new" >
                        Nova Venda
                    </button>

                    <button disabled={enableFinishSale} className="btn btn-danger button-finish" onClick={handleSubmit}>
                        {isSubmitting ? 'Finalizado...' : 'Finalizar Venda'}
                    </button>
                </Col>
            </Row>
        </Content>);

}

export default Sale;