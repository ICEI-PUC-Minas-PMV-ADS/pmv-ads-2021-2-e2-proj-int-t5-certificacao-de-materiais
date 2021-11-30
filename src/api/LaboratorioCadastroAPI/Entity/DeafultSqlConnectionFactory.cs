using LaboratorioCadastroAPI.Entity.Interface;
using System.Data;
using System.Data.SqlClient;

namespace LaboratorioCadastroAPI.Entity
{
    public class DeafultSqlConnectionFactory : IConnectionFactory
    {
        public IDbConnection Connection()
        {
            return new SqlConnection(@"Password=admin123;Persist Security Info=True;User ID=sa;Initial Catalog=LaboratorioDB;Data Source=DESKTOP-IGQJCON\SQLEXPRESS");
        }
    }
}
 