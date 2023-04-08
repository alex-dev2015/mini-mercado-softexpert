const MyTable = ({headers, data} ) => {
    const colunasMapeadas = headers.reduce((mapeamento, header) => {
        mapeamento[header.chave] = header.nome;
        return mapeamento;
    }, {});

    const colunasChave = headers.map((header) => header.chave);

    return (
        <table className="table table-bordered table-hover">
            <thead>
            <tr>
                {colunasChave.map((coluna) => (
                    <th key={coluna} scope="col">{colunasMapeadas[coluna]}</th>
                ))}
            </tr>
            </thead>
            <tbody>
            {data.map((item, index) => (
                <tr key={index}>
                    {colunasChave.map((coluna) => (
                        <td key={coluna}>{item[coluna]}</td>
                    ))}
                </tr>
            ))}
            </tbody>
        </table>
    );
}

export default MyTable;