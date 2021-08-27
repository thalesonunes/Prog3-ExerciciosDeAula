using Microsoft.EntityFrameworkCore;

namespace alunosAPI.Models
{
    public class PessoaDbContext : DbContext
    {
        //Contrutor
        public PessoaDbContext(DbContextOptions<PessoaDbContext> options) : base(options){}

        public DbSet<Pessoa> Pessoas{get; set;}

    }
}