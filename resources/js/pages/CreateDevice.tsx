import { useForm } from '@inertiajs/react';
import React, { useState } from 'react'

export default function CreateDevice() {
    const [rawIp, setRawIp] = useState('');
    const [formattedIP, setFormattedIp] = useState('');

    const { data, setData, post, processing, errors } = useForm({
        ip: '',
        port: '',
    });

    function handleIpChange(e: React.ChangeEvent<HTMLInputElement>) {
        const input = e.target.value.replace(/\D/g, '');
        setRawIp(input);

        // const parts = input.match(/.{1,2}/g) || [];

        const groups: string[] = [];
        let remaining = input;

        for (let i = 0; i < 4; i++) {
            if (remaining.length === 0) break;

            const part = remaining.slice(0, 2);
            groups.push(part);
            remaining = remaining.slice(part.length);
        }

        setFormattedIp(groups.join('.'));
    }

    function handleSubmit(e) {
        e.preventDefault();

        if (!formattedIP || formattedIP.split('.').length !== 4) {
            alert("please enter a complete IP");
            return;
        }

        setData('ip', formattedIP);

        post('/create-device', {
            onSuccess: () => {
                setData({
                    ip: '',
                    port: '',
                });

                setRawIp('');
                setFormattedIp('');
            }
        })
    }

  return (
    <div>
        <form onSubmit={handleSubmit} className='flex flex-col w-1/4 ml-8 mt-8'>
            <h1 className='font-bold text-2xl mb-8'>Create A Device</h1>
            <div className="ipAndPort flex">
                <div className="ipInput my-4">
                    <label htmlFor="ip">Enter IP Address:</label>
                    <input
                        id='ip'
                        type="text"
                        value={rawIp}
                        className='border-2 border-white'
                        onChange={handleIpChange}
                        placeholder='Enter IP'
                    />
                    <p className='text-gra-400 mt-1'>{formattedIP}</p>
                </div>

                <div className="portInput ml-4">
                    <label htmlFor="port">Enter Port Address:</label>
                    <input
                        id='port'
                        type="text"
                        value={data.port}
                        className='border-2 border-white my-4'
                        onChange={(e) => setData('port', e.target.value)}
                        placeholder='Enter Port'
                    />
                </div>
            </div>



            {errors.ip && <div className='text-red-500'>{errors.ip}</div>}

            <button
                type="submit"
                className='bg-blue-700 hover:bg-blue-400 pointer'
                disabled={processing}
            >
                    Create Device
            </button>
        </form>
    </div>
  )
}
