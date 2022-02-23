exports.displayUsers = (req, res) => {

    const { name, email, password } = req.body;


return new Promise((resolve, reject) => {
    try {
        Client.findOne({
            where: {
                email
            }
        }).then(async (response)=> {
            if(!response) {
                resolve(false);
            } else {
                if(!response.dataValues.password || !await response.validPassword(password,
                    response.dataValues.password)) {
                        resolve(false)
                    } else {
                        resolve(response.dataValues)

                        res.status(200).send(response.dataValues.name+ " is authenticated and validated")
                    }       
            } 
        })
    } catch (error) {
        const response = {
         status: 500,
         data: {},
        error: {
         message: "user match failed"
        }
        };
        reject(response);

       }
}) 
}
