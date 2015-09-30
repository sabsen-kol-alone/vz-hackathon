cd src/tests
phantomjs --webdriver=8643 >/tmp/phantomjs.log &2>1 &
../tests/behat
killall -9 phantomjs
cd ../..
