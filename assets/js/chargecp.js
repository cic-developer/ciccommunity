const token_abi = [{
        constant: true,
        inputs: [],
        name: "name",
        outputs: [{ name: "", type: "string" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_spender", type: "address" },
            { name: "_value", type: "uint256" },
        ],
        name: "approve",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "totalSupply",
        outputs: [{ name: "", type: "uint256" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_from", type: "address" },
            { name: "_to", type: "address" },
            { name: "_value", type: "uint256" },
        ],
        name: "transferFrom",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "decimals",
        outputs: [{ name: "", type: "uint8" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [{ name: "_value", type: "uint256" }],
        name: "burn",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [{ name: "", type: "address" }],
        name: "balanceOf",
        outputs: [{ name: "", type: "uint256" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_from", type: "address" },
            { name: "_value", type: "uint256" },
        ],
        name: "burnFrom",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: false,
        inputs: [],
        name: "release",
        outputs: [],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "owner",
        outputs: [{ name: "", type: "address" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "symbol",
        outputs: [{ name: "", type: "string" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "released",
        outputs: [{ name: "", type: "bool" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_to", type: "address" },
            { name: "_value", type: "uint256" },
        ],
        name: "transfer",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [{ name: "", type: "address" }],
        name: "frozenAccount",
        outputs: [{ name: "", type: "bool" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_spender", type: "address" },
            { name: "_value", type: "uint256" },
            { name: "_extraData", type: "bytes" },
        ],
        name: "approveAndCall",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [
            { name: "", type: "address" },
            { name: "", type: "address" },
        ],
        name: "allowance",
        outputs: [{ name: "", type: "uint256" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "target", type: "address" },
            { name: "freeze", type: "bool" },
        ],
        name: "freezeAccount",
        outputs: [],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: false,
        inputs: [{ name: "newOwner", type: "address" }],
        name: "transferOwnership",
        outputs: [],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        inputs: [
            { name: "initialSupply", type: "uint256" },
            { name: "tokenName", type: "string" },
            { name: "tokenSymbol", type: "string" },
        ],
        payable: false,
        stateMutability: "nonpayable",
        type: "constructor",
    },
    {
        anonymous: false,
        inputs: [
            { indexed: false, name: "target", type: "address" },
            { indexed: false, name: "frozen", type: "bool" },
        ],
        name: "FrozenFunds",
        type: "event",
    },
    {
        anonymous: false,
        inputs: [
            { indexed: true, name: "from", type: "address" },
            { indexed: true, name: "to", type: "address" },
            { indexed: false, name: "value", type: "uint256" },
        ],
        name: "Transfer",
        type: "event",
    },
    {
        anonymous: false,
        inputs: [
            { indexed: true, name: "_owner", type: "address" },
            { indexed: true, name: "_spender", type: "address" },
            { indexed: false, name: "_value", type: "uint256" },
        ],
        name: "Approval",
        type: "event",
    },
    {
        anonymous: false,
        inputs: [
            { indexed: true, name: "from", type: "address" },
            { indexed: false, name: "value", type: "uint256" },
        ],
        name: "Burn",
        type: "event",
    },
];
const contract_abi = [{
        "constant": false,
        "inputs": [],
        "name": "acceptOwnership",
        "outputs": [],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "function"
    },
    {
        "constant": false,
        "inputs": [{
                "name": "_from",
                "type": "address"
            },
            {
                "name": "_to",
                "type": "address"
            },
            {
                "name": "_value",
                "type": "uint256"
            },
            {
                "name": "_url",
                "type": "string"
            },
            {
                "name": "_id",
                "type": "string"
            }
        ],
        "name": "deposit_enter",
        "outputs": [],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "function"
    },
    {
        "constant": false,
        "inputs": [],
        "name": "exit",
        "outputs": [],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "function"
    },
    {
        "constant": false,
        "inputs": [],
        "name": "setFreeze",
        "outputs": [],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "function"
    },
    {
        "constant": false,
        "inputs": [{
            "name": "_newManager",
            "type": "address"
        }],
        "name": "transferOwnership",
        "outputs": [],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "function"
    },
    {
        "inputs": [{
            "name": "_tokenAddress",
            "type": "address"
        }],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "constructor"
    },
    {
        "anonymous": false,
        "inputs": [{
                "indexed": false,
                "name": "from",
                "type": "address"
            },
            {
                "indexed": false,
                "name": "to",
                "type": "address"
            },
            {
                "indexed": false,
                "name": "value",
                "type": "uint256"
            },
            {
                "indexed": false,
                "name": "url",
                "type": "string"
            },
            {
                "indexed": false,
                "name": "id",
                "type": "string"
            }
        ],
        "name": "deposit",
        "type": "event"
    },
    {
        "constant": true,
        "inputs": [],
        "name": "freeze",
        "outputs": [{
            "name": "",
            "type": "bool"
        }],
        "payable": false,
        "stateMutability": "view",
        "type": "function"
    },
    {
        "constant": true,
        "inputs": [],
        "name": "manager",
        "outputs": [{
            "name": "",
            "type": "address"
        }],
        "payable": false,
        "stateMutability": "view",
        "type": "function"
    },
    {
        "constant": true,
        "inputs": [],
        "name": "newManager",
        "outputs": [{
            "name": "",
            "type": "address"
        }],
        "payable": false,
        "stateMutability": "view",
        "type": "function"
    },
    {
        "constant": true,
        "inputs": [],
        "name": "tokenAddress",
        "outputs": [{
            "name": "",
            "type": "address"
        }],
        "payable": false,
        "stateMutability": "view",
        "type": "function"
    }
]
const contract_address = "0x5682461966BB835da2C55c883E5C5985c54829e6";
const token_address = "0x7eee60a000986e9efe7f5c90340738558c24317b";
let csrf_key = '';
let csrf_token = '';
let userWallet_in_mypage = '';

$(document).on('ready', async function() {
    const klaytn = window.klaytn;
    if (klaytn === undefined) {
        alert('Klaytn Kaikas??? ???????????? ???????????????.\nKlaytn Kaikas??? ???????????? ?????????');
        let _blank = window.open('https://m.blog.naver.com/PostView.naver?blogId=djg162&logNo=222063902504&proxyReferer=https:%2F%2Fwww.google.com%2F', '_blank');
        if (_blank == null || typeof(_open) == 'undefined') {

            let _conf_result = confirm('Klaytn Kaiaks ?????? ?????? ???????????? ?????? ???????????????????');
            if (_conf_result) {
                location.href = 'https://m.blog.naver.com/PostView.naver?blogId=djg162&logNo=222063902504&proxyReferer=https:%2F%2Fwww.google.com%2F';
                return;
            }
        }
        history.back();
    } else {
        console.log('klaytn : ', klaytn);
        // if (klaytn.selectedAddress.toLowerCase() != userWallet_in_mypage.toLowerCase()) {
        //     alert('???????????? ??????????????? ?????????????????? ??????????????? ???????????? ????????????.');
        // }
    }

    const PER = new caver.klay.Contract(token_abi, token_address);
    const DEPOSIT = new caver.klay.Contract(contract_abi, contract_address)
    try {

        $(document).on('click', '#charge_button', async function() {
            if (!csrf_key || !csrf_token) {
                alert('??????????????? ???????????? ???????????????.');
                return false;
            }
            var reg_num = /^[0-9]*$/;
            let charge_value = $('#charge_input').val();
            // ????????? ?????????
            if (!charge_value) {
                alert('???????????? ?????????????????????.');
                return false;
            }
            // ????????? ?????? ??????
            if (!reg_num.test(charge_value)) {
                alert('???????????? ?????????????????????.');
                return false;
            }
            await klaytn.enable();
            // ??????????????? ?????????????????? ????????????
            const account = klaytn.selectedAddress;
            const token_balance = await PER.methods.balanceOf(account).call();

            const network = klaytn.networkVersion;
            const selected_addr = account;
            const per_token = token_balance / 1000000000000000000;

            if (network !== 8217) {
                alert('Klaytn Kaikas??? Network???\nMain network??? ???????????????');
                location.reload();
                return;
            }
            if (!selected_addr) {
                alert('Klaytn Kaikas??? ????????? ?????? ??????????????????');
                location.reload();
                return;
            }
            if (per_token < 0) {
                alert('Klaytn Kaikas??? PER ????????? ????????????.\nPER ????????? ?????? ?????? ??????????????????');
                location.reload();
                return;
            }

            const approve_data = caver.klay.abi.encodeFunctionCall({
                name: "approve",
                type: "function",
                inputs: [{
                        type: "address",
                        name: "_to",
                    },
                    {
                        type: "uint256",
                        name: "_value",
                    },
                ],
            }, [
                contract_address,
                caver.utils
                .toBN(charge_value)
                .mul(caver.utils.toBN(Number(`1e${18}`)))
                .toString(),
            ]);

            await caver.klay.sendTransaction({
                type: "SMART_CONTRACT_EXECUTION",
                account,
                to: token_address,
                data: approve_data,
                gas: 3000000,
            }).on("receipt", async(receipt) => {
                const sendToPerWallet_data = await caver.klay.abi.encodeFunctionCall({
                    name: "deposit_enter",
                    type: "function",
                    inputs: [{
                            "name": "_from",
                            "type": "address"
                        },
                        {
                            "name": "_to",
                            "type": "address"
                        },
                        {
                            "name": "_value",
                            "type": "uint256"
                        },
                        {
                            "name": "_url",
                            "type": "string"
                        },
                        {
                            "name": "_id",
                            "type": "string"
                        }
                    ],
                }, [
                    account,
                    contract_address,
                    caver.utils
                    .toBN(charge_value)
                    .mul(caver.utils.toBN(Number(`1e${18}`)))
                    .toString(),
                    window.location.hostname,
                    mem_id
                ]);

                const sendToPerWallet = await caver.klay.sendTransaction({
                    type: "SMART_CONTRACT_EXECUTION",
                    account,
                    to: contract_address,
                    data: sendToPerWallet_data,
                    gas: 3000000,
                }).on("transactionHash", async(transactionHash) => {
                    //????????? AJAX ????????? ???????????? ????????? ???????????? ?????????.
                    $.ajax({
                        url: cb_url + '/mypage/charge_ajax',
                        type: 'post',
                        data: {
                            transaction_hash: transactionHash,
                            charge_input: charge_value,
                            csrf_test_name: csrf_token
                        },
                        dataType: 'json',
                        async: false,
                        cache: false,
                        success: function(data) {
                            if (data.result) {
                                alert('??????????????? ?????????????????????.');
                                location.reload();
                            } else {
                                alert('?????? ??? ????????? ?????????????????????.\n????????? ?????? ??????????????????.');
                                return false;
                            }
                        }
                    });
                });

            }).on("error", (error) => {
                console.log("error", error);
            });

        });
    } catch (error) {
        alert('Klaytn Kaikas????????? ?????? ???????????????. ?????????????????? ???????????????.');
        console.log(error);
        // location.href = "/mypage";
    }

});