using Dapper;
using LaboratorioCadastroAPI.Entity;
using LaboratorioCadastroAPI.Entity.Interface;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using System.Data;

namespace LaboratorioCadastroAPI.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class LaboratorioCadastroController : ControllerBase
    {
        private readonly IConnectionFactory connectionFactory;

        public LaboratorioCadastroController(IConnectionFactory connectionFactory)
        {
            this.connectionFactory = connectionFactory;
        }
        [HttpPost]
        [Route("cadastrar")]
        public async Task<IActionResult> Post([FromBody] FormularioCadastro formularioCadastro)
        {
            var url = "INSERT INTO [LaboratorioDb].[dbo].[FormularioCadastro] ([NomeLaboratorio],[CNPJ],[AreiaQuantidade],[CimentoQuantidade],[FerroQuantidade],[Endereco])" +
                "values" +
                "(@NomeLaboratorio,@CNPJ,@AreiaQuantidade,@CimentoQuantidade,@FerroQuantidade,@Endereco)";

            using (var connectionDb = connectionFactory.Connection())
            {
                connectionDb.Open();
                var result = await connectionDb.ExecuteAsync(url,
                    new
                    {
                        NomeLaboratorio = formularioCadastro.NomeLaboratorio,
                        CNPJ = formularioCadastro.CNPJ,
                        AreiaQuantidade = formularioCadastro.Areia,
                        CimentoQuantidade = formularioCadastro.Cimento,
                        FerroQuantidade = formularioCadastro.Ferro,
                        Endereco = formularioCadastro.Endereco
                    });

                return Ok();

            }
        }

        [HttpGet]
        [Route("buscar")]
        public async Task<IActionResult> GetAsync()
        {
            var url = "SELECT * from [LaboratorioDb].[dbo].[FormularioCadastro]";

            using (var connectionDb = connectionFactory.Connection())
            {
                connectionDb.Open();
                var result = await connectionDb.QueryAsync<dynamic>(url);

                return Ok();
            }
        }

    }
}
