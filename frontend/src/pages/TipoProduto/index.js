import {Box, Col, Content, Row, Button} from "adminlte-2-react";
import api from "../../services/api";
import {useEffect, useState, FormEvent} from "react";
import MyTable from "../../Components/MyTable";

const TipoProduto = () => {
    const [dataTypeProduct, setDataTypeProduct] = useState([
        {
            'id': '',
            'product_type_name': '',
            'icms' : '',
            'pis': '',
            'ipi' : ''
        }
    ]);

    const headers = [
        { chave: "id", nome: "#"},
        { chave: "product_type_name", nome: "Tipo de Produto"},
        { chave: "icms", nome: "ICMS"},
        { chave: "pis", nome: "PIS"},
        { chave: "ipi", nome: "IPI"},
    ];

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
            })
            .catch((error) => {
                console.error(error.response.data);
                alert('Erro ao carregar: \n' + error.response.data.message)
        })
    };

    useEffect(() => {
        api.get('product_type')
            .then((result) => {
                setDataTypeProduct(result.data.dados)
            })
            .catch((error) => {
                console.error(error.response.data);
                alert('Erro ao carregar: \n' + error.response.data.message)
            })
    }, [])

    const handleSubmit = (event) => {
        event.preventDefault();
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
                    <Box title="Tipos" type="info" >
                        <MyTable headers={headers} data={dataTypeProduct} />
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
                                               { ...formValues, product_type_name: event.target.value }
                                           )}
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
                                                   { ...formValues, icms: event.target.value }
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
                                                   { ...formValues, pis: event.target.value }
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
                                                   { ...formValues, ipi: event.target.value }
                                               )}
                                        />
                                    </div>
                            </div>

                           <button type="submit" className="btn btn-primary">Gravar</button>
                        </form>

                    </Box>
                </Col>
            </Row>
        </Content>);
}

export default TipoProduto;