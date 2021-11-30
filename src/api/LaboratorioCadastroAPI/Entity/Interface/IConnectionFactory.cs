using System.Data;

namespace LaboratorioCadastroAPI.Entity.Interface
{
    public interface IConnectionFactory
    {
        IDbConnection Connection();
    }
}
