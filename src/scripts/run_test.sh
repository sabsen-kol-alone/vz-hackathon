cd src/tests
phantomjs --webdriver=8643 >/tmp/phantomjs.log &2>1 &
src/visual/vendor/behat/behat/bin/behat
killall -9 phantomjs
cd ../..
