package primos.soga.perfil.contacto;

import jakarta.persistence.*;
import lombok.Data;
import primos.soga.perfil.Perfil;
import primos.soga.perfil.contacto.enums.TipoContacto;

import java.util.UUID;

@Data
@Entity
public class Contacto {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private UUID id;
    @Enumerated(EnumType.STRING)
    private TipoContacto tipo;
    private String contacto;

    @ManyToOne
    @JoinColumn(name = "perfil_id")
    private Perfil perfil;
}