describe('Login de usuário', () => {
  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('[data-testid="input-email"]', { timeout: 10000 }).should('exist')
  })

  it('deve fazer login com dados válidos', () => {
    cy.intercept('POST', '/register').as('postRegister')
    cy.intercept('POST', '/login').as('postLogin')

    const email = `login${Date.now()}@teste.com`
    const senha = 'senha123'

    // Registra usuário antes de logar
    cy.visit('http://127.0.0.1:8000/register')
    cy.get('[data-testid="input-name"]').type('Usuário Login')
    cy.get('[data-testid="input-email"]').type(email)
    cy.get('[data-testid="input-password"]').type(senha)
    cy.get('[data-testid="btn-submit"]').click()
    cy.wait('@postRegister')

    // Vai para tela de login
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('[data-testid="input-email"]').type(email)
    cy.get('[data-testid="input-password"]').type(senha)
    cy.get('[data-testid="btn-submit"]').click()

    cy.wait('@postLogin')
    cy.waitForSnackbar('Login realizado com sucesso!')
  })

  it('exibe erro com credenciais inválidas', () => {
    cy.intercept('POST', '/login').as('postLogin')

    cy.get('[data-testid="input-email"]').type('email@invalido.com')
    cy.get('[data-testid="input-password"]').type('senhaerrada')
    cy.get('[data-testid="btn-submit"]').click()

    cy.wait('@postLogin')
    cy.waitForSnackbar('Credenciais inválidas')
  })
})
