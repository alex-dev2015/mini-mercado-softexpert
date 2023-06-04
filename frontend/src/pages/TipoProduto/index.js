import {Box, Col, Content, Row} from "adminlte-2-react";
import MyTable from "../../Components/MyTable";
import {useEffect, useRef, useState} from "react";
import {floatToPercentage} from "../../utils/globalFunctions";

import api from "../../services/api";

const TipoProduto = () => {
    const [isSubmitting, setIsSubmitting] = useState(false);
    const inputRef = useRef(null);
    const [dataTypeProduct, setDataTypeProduct] = useState([
        {
            'id': '',
            'product_type_name': '',
            'icms': '',
            'pis': '',
            'ipi': ''
        }
    ]);

    const headers = [
        {chave: "id", nome: "#"},
        {chave: "product_type_name", nome: "Tipo de Produto"},
        {chave: "icms", nome: "ICMS"},
        {chave: "pis", nome: "PIS"},
        {chave: "ipi", nome: "IPI"},
    ];

    const alignments = {
        id: "center",
        product_type_name: "left",
        icms: "center",
        pis: "center",
        ipi: "center"
    };

    const [formValues, setFormValues] = useState({
        product_type_name: '',
        icms: '',
        pis: '',
        ipi: '',

    });

    const updateList = () => {
        api.get('product_type')
            .then((result) => {
                setDataTypeProduct(result.data.dados)
                setIsSubmitting(false);
                setFormValues({
                    product_type_name: '',
                    icms: '',
                    pis: '',
                    ipi: '',
                })
                inputRef.current.focus();
            })
            .catch((error) => {
                setIsSubmitting(false);
                console.error(error.response.data);
                alert('Erro ao carregar: \n' + error.response.data.mensagem)
            })
    };

    useEffect(() => {
        api.get('product_type')
            .then((response) => {
                const formattedData = response.data.dados.map((product) => {
                    return {
                        ...product,
                        icms: floatToPercentage(product.icms),
                        pis: floatToPercentage(product.pis),
                        ipi: floatToPercentage(product.ipi)
                    };
                });
                setDataTypeProduct(formattedData)
            })
            .catch((error) => {
                console.error(error.response.data);
                alert('Erro ao carregar: \n' + error.response.data.mensagem)
            })
    }, [])

    const handleSubmit = (event) => {
        event.preventDefault();
        setIsSubmitting(true);
        api.post('product_type', formValues)
            .then(response => {

                updateList();
            })
            .catch(error => {
                console.log(error);
            });
    };

    return (
        <Content title="Página de Tipo de Produtos" homeRoute="/home" subTitle="SoftExpert" browserTitle="Soft|EXPERT">
            <Row>
                <Col xs={6}>
                    <Box title="Tipos" type="info">
                        <MyTable headers={headers} alignments={alignments} data={dataTypeProduct}
                                 table={"table-bordered"}/>
                    </Box>
                </Col>
                <Col xs={6}>
                    <Box title="Cadastro" type="primary">
                        <form onSubmit={handleSubmit}>
                            <div className="card-body">
                                <div className="form-group">
                                    <label htmlFor="nome">Descrição</label>
                                    <input type="text"
                                           className="form-control"
                                           name="product_type_name"
                                           value={formValues.product_type_name}
                                           onChange={(event) => setFormValues(
                                               {...formValues, product_type_name: event.target.value}
                                           )}
                                           ref={inputRef}
                                    />
                                </div>

                                <div className="form-group">
                                    <label htmlFor="nome">ICMS</label>
                                    <input type="text"
                                           className="form-control"
                                           name="icms"
                                           value={formValues.icms}
                                           placeholder="8"
                                           onChange={(event) => setFormValues(
                                               {...formValues, icms: event.target.value}
                                           )}
                                    />
                                </div>

                                <div className="form-group">
                                    <label htmlFor="nome">PIS</label>
                                    <input type="text"
                                           className="form-control"
                                           name="pis"
                                           value={formValues.pis}
                                           placeholder="2,5"
                                           onChange={(event) => setFormValues(
                                               {...formValues, pis: event.target.value}
                                           )}
                                    />
                                </div>

                                <div className="form-group">
                                    <label htmlFor="nome">IPI</label>
                                    <input type="text"
                                           className="form-control"
                                           name="ipi"
                                           placeholder="1,5"
                                           value={formValues.ipi}
                                           onChange={(event) => setFormValues(
                                               {...formValues, ipi: event.target.value}
                                           )}
                                    />
                                </div>
                            </div>

                            <button
                                type="submit"
                                disabled={isSubmitting}
                                className="btn btn-primary"
                            >{isSubmitting ? 'Salvando...' : 'Salvar'}</button>
                        </form>

                    </Box>
                </Col>
            </Row>
        </Content>);
}

export default TipoProduto;