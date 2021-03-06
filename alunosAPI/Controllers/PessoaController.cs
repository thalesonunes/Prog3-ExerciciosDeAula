using System.Collections.Generic;
using alunosAPI.Models;
using alunosAPI.Repository;
using Microsoft.AspNetCore.Mvc;

namespace alunosAPI.Controllers
{
    [Route("api/[Controller]")] // no navegador fica assim: https://localhost:5001/api/Pessoa
    public class PessoaController : Controller
    {
        //Atributos
        private readonly IPessoaRepository pessoaRepository;

        public PessoaController(IPessoaRepository pessoaRepository)
        {
            this.pessoaRepository = pessoaRepository;
        }

        /* Métodos HTML- Verbos:
        GET    - Trazer a informação
        PUT    - Atualizar(Update)
        POST   - Adicionar (new)
        DELETE - Remover(delete)
        */
        [HttpGet]
        public IEnumerable<Pessoa> GetAll()
        {
            return pessoaRepository.GetAll();
        }

        [HttpGet("{idpessoas}", Name="GetPessoa")]
        public IActionResult GetById(long idpessoas){
            var pessoa = pessoaRepository.Find(idpessoas);
            if(pessoa == null)
                return NotFound(); //status code 404
                return new ObjectResult(pessoa);
            
        }
        [HttpPost]
        public IActionResult Create([FromBody]Pessoa pessoa){
            if(pessoa == null)
            return BadRequest(); //Status code 400.
            pessoaRepository.Add(pessoa);
            return CreatedAtRoute("GetPessoa", new{idpessoas = pessoa.idpessoas},pessoa);
        }

        [HttpPut]
        public IActionResult Update([FromBody] Pessoa pessoa){
            var pessoaUpdate = pessoaRepository.Find(pessoa.idpessoas);
            if(pessoaUpdate == null)
            return NotFound(); // Erro 404.
            if(pessoa == null || pessoaUpdate.idpessoas != pessoa.idpessoas)
                return BadRequest(); // Erro 400.
            // Regra de Negócio:
            // atualizar nome, idade, cpf;
            pessoaUpdate.nome = pessoa.nome;
            pessoaUpdate.idade = pessoa.idade;
            pessoaUpdate.cpf = pessoa.cpf;
            pessoaRepository.Update(pessoaUpdate);
            return new NoContentResult(); // Erro 204.

        }
        [HttpDelete("{idpessoas}")]
        public IActionResult Delete(long idpessoas){
            var pessoaDelete = pessoaRepository.Find(idpessoas);
            if(pessoaDelete == null)
                return NotFound();// Erro 404.
            pessoaRepository.Remove(idpessoas);
            return new NoContentResult();// Erro 204.
        }

        
    }
}