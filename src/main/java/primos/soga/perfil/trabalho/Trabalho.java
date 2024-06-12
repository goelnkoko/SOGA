package primos.soga.perfil.trabalho;

import jakarta.persistence.*;
import lombok.Data;
import primos.soga.perfil.Perfil;

import java.util.Date;
import java.util.UUID;

@Data
@Entity
public class Trabalho {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private UUID id;
    private String descricao;
    private String trabalho;
    private String organizacao;
    private Date dataInicio;
    private Date dataDeTermino;

    @ManyToOne
    @JoinColumn(name = "perfil_id")
    private Perfil perfil;
}
