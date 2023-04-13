import {Box, Col, Content, Row, Button} from "adminlte-2-react";
import MyTable from "../../Components/MyTable";
import {useEffect, useRef, useState} from "react";
import api from "../../services/api";
import {formatCurrency} from "../../utils/globalFunctions";

const Produto = () => {
    const [isSubmitting, setIsSubmitting] = useState(false);
    const inputRef = useRef(null);
    const [dadosProdutos, setDadosProdutos] = useState([
        {
            'id': 0,
            'product_name': '',
            'price': 0,
            'type_id': 0
        }
    ]);

    const [formValues, setFormValues] = useState({
        product_name: '',
        price: '',
        type_id: '',
    });

    const headers = [
        {chave: "id", nome: "#"},
        {chave: "product_name", nome: "Produtos"},
        {chave: "price", nome: "Preço"},
    ];

    const alignments = {
        id: "center",
        product_type_name: "left",
        price: "right"
    };

    const [optionTypeProduct, setOptionTypeProduct] = useState([]);

    const updateList = () => {
        api.get('products')
            .then((result) => {
                setDadosProdutos(result.data.dados)
                setIsSubmitting(false);
                setFormValues({
                    product_name: '',
                    price: '',
                    type_id: '',
                });
                inputRef.current.focus();
            })
            .catch((error) => {
                setIsSubmitting(false);
                console.error(error.response.data);
                alert('Erro ao carregar: \n' + error.response.data.message)
            })
    };

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
                const formattedData = response.data.dados.map((product) => {
                    return {
                        ...product,
                        price: formatCurrency(product.price)
                    };
                });
                setDadosProdutos(formattedData);
            })
            .catch((error) => {
                console.error(error.response.data);
                alert('Erro ao carregar: \n' + error.response.data.mensagem)
            })
    }, [])

    const handleSubmit = (event) => {
        event.preventDefault();
        setIsSubmitting(true);
        api.post('products', formValues)
            .then(response => {
                updateList();
            })
            .catch(error => {
                setIsSubmitting(false);
                alert('Erro ao Gravar: ' + error.response.data.mensagem)
            });
    };

    return (<Content title="Página de Produtos" homeRoute="/home" subTitle="SoftExpert" browserTitle="Soft|EXPERT">
        <Row>
            <Col xs={6}>
                <Box title="Produtos" type="info">
                    <MyTable headers={headers} alignments={alignments} data={dadosProdutos} table={"table-bordered"}/>
                </Box>
            </Col>
            <Col xs={6}>
                <Box title="Cadastro" type="primary">
                    <form onSubmit={handleSubmit}>
                        <div className="card-body">
                            <div className="form-group">
                                <label htmlFor="nome">Tipo de Produto</label>
                                <select className="form-control"
                                        onChange={(event) => setFormValues(
                                            {...formValues, type_id: event.target.value}
                                        )}
                                        ref={inputRef}
                                >
                                    <option disabled value="0" selected>SELECIONE UM TIPO DE PRODUTO</option>
                                    {optionTypeProduct.map(opcao => (
                                        <option key={opcao.id} value={opcao.id}>{opcao.product_type_name}</option>
                                    ))}
                                </select>
                            </div>

                            <div className="form-group">
                                <label htmlFor="product_name">Descrição</label>
                                <input type="text"
                                       className="form-control"
                                       id="product_name"
                                       placeholder="Descrição Tipo de Produto"
                                       value={formValues.product_name}
                                       onChange={(event) => setFormValues(
                                           {...formValues, product_name: event.target.value}
                                       )}
                                />
                            </div>
                            <div className="form-group">
                                <label htmlFor="price">Valor</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    id="price"
                                    placeholder="1.500"
                                    value={formValues.price}
                                    onChange={(event) => setFormValues(
                                        {...formValues, price: event.target.value}
                                    )}
                                />
                            </div>
                        </div>
                        <div className="card-footer">
                            <button
                                type="submit"
                                disabled={isSubmitting}
                                className="btn btn-primary"
                            >
                                {isSubmitting ? 'Salvando...' : 'Salvar'}
                            </button>
                        </div>
                    </form>
                </Box>
            </Col>
        </Row>
    </Content>);
}

export default Produto;