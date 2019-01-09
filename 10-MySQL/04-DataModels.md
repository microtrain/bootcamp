# Data Models
https://en.wikipedia.org/wiki/First_normal_form
Customer data with one or many phone numbers stored in a single row.

<table>
<caption>customers</caption>
<tr>
<th>id</th>
<th>first_name</th>
<th>last_name</th>
<th>phone</th>
</tr>
<tr>
<td>123</td>
<td>John</td>
<td>Smith</td>
<td>(555) 861-2025, (555) 122-1111</td>
</tr>
<tr>
<td>456</td>
<td>Jane</td>
<td>Doe</td>
<td>(555) 403-1659, (555) 929-2929</td>
</tr>
<tr>
<td>789</td>
<td>Cindy</td>
<td>Who</td>
<td>(555) 808-9633</td>
</tr>
</table>

```
SELECT phone FROM customers WHERE id = 123
```

1 result
(555) 861-2025, (555) 122-1111

Thrid normal form would change this so that the customer data and phone numbers are sotred in seprate tables and associated using the customer_id. 

<table>
<caption>customers</caption>
<tr>
<th>id</th>
<th>first_name</th>
<th>last_name</th>
</tr>
<tr>
<td>123</td>
<td>John</td>
<td>Smith</td>
</tr>
<tr>
<td>456</td>
<td>Jane</td>
<td>Doe</td>
</tr>
<tr>
<td>789</td>
<td>Cindy</td>
<td>Who</td>
</tr>
</table>

<table>
<caption>phone_numbers</caption>
<tr>
<th>customer_id</th>
<th>phone</th>
</tr>
<tr>
<td>123</td>
<td>(555) 122-1111</td>
</tr>
<tr>
<td>123</td>
<td>(555) 861-2025</td>
</tr>
<tr>
<td>456</td>
<td>(555) 403-1659</td>
</tr>
<tr>
<td>456</td>
<td>(555) 929-2929</td>
</tr>
<tr>
<td>789</td>
<td>(555) 808-9633</td>
</tr>
</table>

[Next: MySQL with PHP](/10-MySQL/05-MySQLWithPHP.md)
