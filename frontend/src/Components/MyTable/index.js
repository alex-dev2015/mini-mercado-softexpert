const MyTable = ({headers, data, table, alignments}) => {
    const colunasMapeadas = headers.reduce((mapeamento, header) => {
        mapeamento[header.chave] = header.nome;
        return mapeamento;
    }, {});

    const colunasChave = headers.map((header) => header.chave);

    return (
        <table className={`table ${table} table-hover`}>
            <thead>
            <tr>
                {colunasChave.map((coluna) => (
                    <th key={coluna} scope="col" style={{textAlign: alignments[coluna]}}>
                        {colunasMapeadas[coluna]}
                    </th>
                ))}
            </tr>
            </thead>
            <tbody>
            {data.map((item, index) => (
                <tr key={index}>
                    {colunasChave.map((coluna) => (
                        <td key={coluna} style={{textAlign: alignments[coluna]}}>
                            {item[coluna]}
                        </td>
                    ))}
                </tr>
            ))}
            </tbody>
        </table>
    );
}

export default MyTable;