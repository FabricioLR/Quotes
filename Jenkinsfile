pipeline {
    agent any
    triggers {
        githubPush()
    }
    options {
        ansiColor('xterm')
    }
    stages {
        stage('Build Production') {
            steps {
                withCredentials([
                    string(credentialsId: 'quotes_app_key', variable: 'APP_KEY'),
                    string(credentialsId: 'quotes_db_password', variable: 'DB_PASSWORD'),
                    string(credentialsId: 'quotes_db_username', variable: 'DB_USERNAME'),
                    string(credentialsId: 'quotes_db_database', variable: 'DB_DATABASE')
                ]) {
                    sh """
                    echo "APP_NAME=Quotes" > .env.prod
                    echo "APP_ENV=production" >> .env.prod
                    echo "APP_LOCALE=pt_BR" >> .env.prod
                    echo "APP_DEBUG=false" >> .env.prod
                    echo "APP_KEY=${APP_KEY}" >> .env.prod
                    echo "APP_URL=https://citacoes.online" >> .env.prod
                    echo "LOG_CHANNEL=stack" >> .env.prod
                    echo "LOG_LEVEL=info" >> .env.prod
                    echo "DB_CONNECTION=pgsql" >> .env.prod
                    echo "DB_HOST=10.0.0.110" >> .env.prod
                    echo "DB_PORT=5432" >> .env.prod
                    echo "DB_DATABASE=${DB_DATABASE}" >> .env.prod
                    echo "DB_USERNAME=${DB_USERNAME}" >> .env.prod
                    echo "DB_PASSWORD=${DB_PASSWORD}" >> .env.prod
                    echo "SESSION_DRIVER=file" >> .env.prod
                    echo "SESSION_LIFETIME=120" >> .env.prod
                    echo "CACHE_DRIVER=file" >> .env.prod
                    echo "QUEUE_CONNECTION=file" >> .env.prod
                    echo "VITE_APP_NAME=Quotes" >> .env.prod
                    """
                    sh 'docker compose -f docker-compose.prod.yaml build'
                }
            }
        }
        stage('Deploy') {
            steps {
                sh 'docker compose -f docker-compose.prod.yaml down'
                sh 'docker compose -f docker-compose.prod.yaml up -d'
            }
        }
    }
    
    post {
        always {
            sh 'docker compose -p test -f docker-compose.test.yaml down || true'
            cleanWs()
        }
    }
}