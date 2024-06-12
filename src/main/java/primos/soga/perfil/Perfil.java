package primos.soga.perfil;

import jakarta.persistence.*;
import lombok.Data;
import primos.soga.perfil.contacto.Contacto;
import primos.soga.perfil.educacao.Educacao;
import primos.soga.perfil.trabalho.Trabalho;
import primos.soga.user.User;

import java.util.List;
import java.util.UUID;

@Data
@Entity
public class Perfil {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private UUID id;
    private String foto;
    private String biografia;
    @ElementCollection
    private List<String> hobby;
    @ElementCollection
    private List<String> interesses;

    @OneToMany(mappedBy = "perfil", cascade = CascadeType.ALL, orphanRemoval = true)
    private List<Educacao> educacoes;

    @OneToMany(mappedBy = "perfil", cascade = CascadeType.ALL, orphanRemoval = true)
    private List<Trabalho> trabalhos;

    @OneToMany(mappedBy = "perfil", cascade = CascadeType.ALL, orphanRemoval = true)
    private List<Contacto> contactos;

    @OneToOne
    @JoinColumn(name = "user_id")
    private User user;
}
