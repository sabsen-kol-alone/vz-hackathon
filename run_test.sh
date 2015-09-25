cd tests
pwd
echo 'Parent:'
ls -l ../

echo 'Bin:'
ls -l ../bin

../vendor/behat/behat/bin/behat

return_code=$?
if [ $return_code = 0 ]
then
  echo "Test successful ..."
else
  echo "Failed test .."
fi
cd ../
exit $return_code
