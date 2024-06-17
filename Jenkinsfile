pipeline {
    agent any

    stages {
        stage('Preparacion') {
            steps {
                git branch: 'main', url: 'https://github.com/josebiton/gpi-testing.git'
                echo 'Pulled from GitHub successfully'
            }
        }


        stage('Verifica version php') {
            steps {
                sh 'php --version'
            }
        }
     stage('Docker Build') {
            steps {
                sh 'docker build -t gpi-testing .'
            }
        }
        stage('Deploy php') {
            steps {
                sh 'docker compose up -d'
            }
        }
     
    }
}
