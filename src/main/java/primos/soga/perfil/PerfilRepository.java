package primos.soga.perfil;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;

import java.util.UUID;

public interface PerfilRepository extends JpaRepository<Perfil, UUID>, JpaSpecificationExecutor<Perfil> {
}
