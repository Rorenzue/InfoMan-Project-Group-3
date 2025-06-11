/*SIMPLE 3
Select
From
Where (operators)
Order by*/

SELECT Appli_Num, Assistance_Applied 
FROM appli_details
WHERE Assistance_Applied IN ('PHD', 'MASTERS')
ORDER BY Assistance_Applied ASC;

SELECT LRN, CONCAT(FirstName, ' ', MidName, ' ', LastName, ' ', Suffix) AS FullName, EthnoGroupStudent, Parent_Income
FROM appli_profile
WHERE Sex = 'F'
	  AND Parent_Income IN ('Below_50k', '50k_100k')
ORDER BY LastName ASC;

SELECT LRN, Year_Grad, Ave_Grade, Ranking
FROM educ_bg
WHERE (Ave_Grade >= 1 AND Ave_Grade <= 1.75) 
	   OR Ave_Grade > 95;

/*AVERAGE 4
Group by */

SELECT * FROM educ_Bg;

SELECT School_T ype, COUNT(*) AS NumberOfSchool
FROM schooldetails
GROUP BY School_Type
ORDER BY NumberOfSchool DESC;

SELECT educ_background, ROUND(AVG(ave_grade), 2)
FROM educ_bg
GROUP BY Educ_Background
HAVING Educ_Background IN ('ES', 'JHS', 'SHS')
ORDER BY Educ_Background;

SELECT Assistance_Type, COUNT(*) AS TotalApplicant
FROM appli_details 
GROUP BY Assistance_Type;

SELECT YEAR(Birthdate) AS BirthYear, COUNT(*) AS TotalApplicants
FROM appli_profile
WHERE (DATEDIFF(CURDATE(), Birthdate) / 365) > 18
GROUP BY BirthYear;

/*DIFFICULT 3
Multiple table*/
SELECT E.LRN, LASTNAME, ROUND(AVG(Ave_grade), 2)
FROM appli_profile ap, Educ_bg e
WHERE e.lrn = ap.lrn AND educ_background IN ('ES', 'JHS', 'SHS')
GROUP BY E.lrn;

SELECT ad.Appli_Num, LastName, DegreeProgram, School_Name, PrioNum
FROM appli_details AS ad, appli_profile as ap, prioritylist as p, schooldetails as S, degree_program AS d
WHERE ad.Appli_Num = p.Appli_Num
	AND ad.LRN = ap.LRN
    AND p.School_Code = s.School_Code
    AND p.DegCode = d.DegCode
ORDER BY ad.Appli_Num, PrioNum ASC;

SELECT School_Name, COUNT(*) AS TimesSelected
FROM schooldetails as s, prioritylist as p
WHERE s.School_Code = p.School_Code
GROUP BY s.School_Code
ORDER BY s.School_Code;

SELECT * FROM appli_details;

SELECT Appli_Num, Assistance_Type, Assistance_Applied, LastName, Educ_Background, 
	   School_Name, School_Type, Ave_Grade, Ranking
FROM appli_details as ad, appli_profile as ap, educ_bg as e, schooldetails as s
WHERE ad.LRN = ap.LRN
	  AND ap.LRN = e.LRN
      AND e.SchoolCode = s.School_Code
      AND Ranking != 'N/A';
