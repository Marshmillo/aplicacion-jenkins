#!groovy

node {

  stage "Checkout Git repo"
    checkout scm
  stage "Run tests"
    sh "sudo docker run -v \$(pwd):/app --rm phpunit/phpunit tests/"
  stage "Build RPM"
    sh "[ -d ./rpm ] || mkdir ./rpm"
    sh "sudo docker run -v \$(pwd)/src:/data/demo-app -v \$(pwd)/rpm:/data/rpm --rm tenzer/fpm -s dir -t rpm -n demo-app -v \$(git rev-parse --short HEAD) --description \"Demo PHP app\" --directories /var/www/demo-app --package /data/rpm/demo-app-\$(git rev-parse --short HEAD).rpm /data/demo-app=/var/www/"
  stage "Update YUM repo"
    sh "sudo [ -d ~/repo/rpm/demo-app/ ] || sudo mkdir -p ~/repo/rpm/demo-app/"
    sh "sudo mv ./rpm/*.rpm ~/repo/rpm/demo-app/"
    sh "sudo createrepo ~/repo/"
    sh "sudo aws s3 sync ~/repo s3://pdg-test-bucket/ --region us-east-1 --delete"
  stage "Check YUM repo"
    sh "sudo yum clean all"
    sh "sudo yum info demo-app-\$(git rev-parse --short HEAD)"
}