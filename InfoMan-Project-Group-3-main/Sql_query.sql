/*SIMPLE 3
Select
From
Where (operators)
Order by*/

SELECT Appli_Num, Assistance_Applied 
FROM appli_details
WHERE Assistance_Applied IN ('PHD', 'MASTERS')
ORDER BY Assistance_Applied ASC;

SELECT LRN, CONCAT(FirstName, ' ', MidName, ' ', LastName, ' ', Suffix) AS FullName, EthnoGroupStudent
FROM appli_profile
WHERE Sex = 'F'
ORDER BY LastName ASC;

SELECT * FROM educ_bg;
SELECT LRN, Year_Grad, Ave_Grade, Ranking
FROM educ_bg
WHERE (Ave_Grade >= 1 AND Ave_Grade <= 1.75) 
	   OR Ave_Grade > 95;

/*AVERAGE 4
Group by */

SELECT * FROM educ_Bg;

SELECT School_Type, COUNT(*) AS NumberOfSchool
FROM schooldetails
GROUP BY School_Type
ORDER BY NumberOfSchool DESC;

SELECT educ_background, ROUND(AVG(ave_grade), 2)
FROM educ_bg
GROUP BY Educ_Background;

SELECT Assistance_Type, count(*) AS TotalApplicant
FROM appli_details 
GROUP BY Assistance_Type;



/*DIFFICULT 3
Multiple table*/