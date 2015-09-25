cd tests
bin/behat
return_code=$?
if [ $return_code = 0 ]
then
  echo "Test successful ..."
else
  echo "Failed test .."
fi
cd ../
exit $return_code
