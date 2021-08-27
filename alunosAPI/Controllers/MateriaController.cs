using System.Collections.Generic;
using alunosAPI.Models;
using alunosAPI.Repository;
using Microsoft.AspNetCore.Mvc;

namespace alunosAPI.Controllers
{
    [Route("api/[Controller]")] // no navegador fica assim: https://localhost:5001/api/Materia
    public class MateriaController : Controller
    {
        //Atributos
        private readonly IMateriaRepository materiaRepository;

        public MateriaController(IMateriaRepository materiaRepository)
        {
            this.materiaRepository = materiaRepository;
        }

        /* Métodos HTML- Verbos:
        GET    - Trazer a informação
        PUT    - Atualizar(Update)
        POST   - Adicionar (new)
        DELETE - Remover(delete)
        */

        // BUSCA TODAS AS MATÉRIAS NO BANCO DE DADOS
        [HttpGet]
        public IEnumerable<Materia> GetAll()
        {
            return materiaRepository.GetAll();
        }

        // BUSCA MATÉRIAS POR ID NO BANCO DE DADOS
        [HttpGet("{idmaterias}", Name = "GetMateria")]
        public IActionResult GetById(int idmaterias)
        {
            var materia = materiaRepository.Find(idmaterias);
            if (materia == null)
                return NotFound(); //status code 404
            return new ObjectResult(materia);

        }

        // ADICIONA DADOS A MATÉRIA NO BANCO DE DADOS
        [HttpPost]
        public IActionResult Create([FromBody] Materia materia)
        {
            if (materia == null)
                return BadRequest(); //Status code 400.
            materiaRepository.Add(materia);
            return CreatedAtRoute("GetMateria", new { idmaterias = materia.idmaterias }, materia);
        }

        // UPDATE EM MATÉRIA NO BANCO DE DADOS
        [HttpPut]
        public IActionResult Update([FromBody] Materia materia)
        {
            var materiaUpdate = materiaRepository.Find(materia.idmaterias);
            if (materiaUpdate == null)
                return NotFound(); // Erro 404.
            if (materia == null || materiaUpdate.idmaterias != materia.idmaterias)
                return BadRequest(); // Erro 400.
            // Regra de Negócio:
            // atualizar nome, periodo, carga_horaria;
            materiaUpdate.nome = materia.nome;
            materiaUpdate.periodo = materia.periodo;
            materiaUpdate.carga_horaria = materia.carga_horaria;
            materiaRepository.Update(materiaUpdate);
            return new NoContentResult(); // Erro 204.

        }

        // DELETA MATÉRIA POR ID NO BANCO DE DADOS
        [HttpDelete("{idmaterias}")] // Deletar, apagar, excluir dados do BD Matéria.
        public IActionResult Delete(int idmaterias)
        {
            var materiaDelete = materiaRepository.Find(idmaterias);
            if (materiaDelete == null)
                return NotFound();// Erro 404.
            materiaRepository.Remove(idmaterias);
            return new NoContentResult();// Erro 204.
        }
    }
}