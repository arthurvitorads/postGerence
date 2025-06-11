describe('Registro de usuário', () => {
  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/register')
    cy.get('input[name="name"]', { timeout: 10000 }).should('exist')
  })

  it('deve registrar um usuário com dados válidos', () => {
    cy.intercept('POST', '/register').as('postRegister')

    cy.get('input[name="name"]').type('Usuário Teste')
    cy.get('input[name="email"]').type(`teste${Date.now()}@exemplo.com`)
    cy.get('input[name="password"]').type('senha123')

    cy.get('[data-testid="btn-submit"]').click()
    cy.wait('@postRegister')

    cy.waitForSnackbar('Registrado com sucesso!')
  })

  it('exibe erro se campos estiverem vazios', () => {
    cy.intercept('POST', '/register').as('postRegister')

    cy.get('[data-testid="btn-submit"]').click()
    cy.wait('@postRegister')

    cy.waitForSnackbar('O nome é obrigatório. | O email é obrigatório. | A senha é obrigatória.')
  })
})
 